<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Models\HousingApplication;
use App\Models\Scheme;
use App\Models\Village;
use App\Notifications\ApplicationStatusNotification;
use App\Services\AuditLogService;
use App\Services\ReferenceNumberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HousingApplicationController extends Controller
{
    public function __construct(
        protected AuditLogService $auditLog,
        protected ReferenceNumberService $references,
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', HousingApplication::class);

        $query = HousingApplication::query()
            ->with(['beneficiary', 'scheme', 'village.block.district', 'assignedOfficer']);

        if ($request->user()->isCustomer()) {
            $query->where('user_id', $request->user()->id);
        }

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('application_number', 'like', "%{$search}%")
                    ->orWhereHas('beneficiary', fn ($b) => $b->where('name', 'like', "%{$search}%")
                        ->orWhere('unique_user_id', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($schemeId = $request->integer('scheme_id')) {
            $query->where('scheme_id', $schemeId);
        }

        $applications = $query->latest()->paginate(12)->withQueryString();

        return view('mis.applications.index', [
            'applications' => $applications,
            'schemes' => Scheme::query()->where('is_active', true)->orderBy('name')->get(),
            'statuses' => ApplicationStatus::cases(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', HousingApplication::class);

        return view('mis.applications.create', [
            'schemes' => Scheme::query()->where('is_active', true)->orderBy('name')->get(),
            'villages' => Village::query()->with('block.district')->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', HousingApplication::class);

        $validated = $request->validate([
            'scheme_id' => ['required', 'exists:schemes,id'],
            'village_id' => ['required', 'exists:villages,id'],
            'site_address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $application = HousingApplication::query()->create([
            ...$validated,
            'application_number' => $this->references->application(),
            'user_id' => $request->user()->id,
            'status' => ApplicationStatus::Draft,
        ]);

        $this->auditLog->log('application.created', "Application {$application->application_number} created.", $application);

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Application draft saved. Submit when ready.');
    }

    public function show(HousingApplication $application): View
    {
        $this->authorize('view', $application);

        $application->load([
            'beneficiary', 'scheme', 'village.block.district',
            'assignedOfficer', 'progressEntries.recordedBy',
            'financialRecords.recordedBy', 'documents.uploader',
        ]);

        return view('mis.applications.show', compact('application'));
    }

    public function edit(HousingApplication $application): View
    {
        $this->authorize('update', $application);

        return view('mis.applications.edit', [
            'application' => $application,
            'schemes' => Scheme::query()->where('is_active', true)->orderBy('name')->get(),
            'villages' => Village::query()->with('block.district')->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, HousingApplication $application): RedirectResponse
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'scheme_id' => ['required', 'exists:schemes,id'],
            'village_id' => ['required', 'exists:villages,id'],
            'site_address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $application->update($validated);

        $this->auditLog->log('application.updated', "Application {$application->application_number} updated.", $application);

        return redirect()
            ->route('applications.show', $application)
            ->with('status', 'Application updated.');
    }

    public function submit(Request $request, HousingApplication $application): RedirectResponse
    {
        $this->authorize('update', $application);

        abort_unless($application->status === ApplicationStatus::Draft, 403);

        $application->update([
            'status' => ApplicationStatus::Submitted,
            'submitted_at' => now(),
        ]);

        $this->auditLog->log('application.submitted', "Application {$application->application_number} submitted for review.", $application);
        $application->beneficiary->notify(new ApplicationStatusNotification($application, 'Your housing application has been submitted for review.'));

        return back()->with('status', 'Application submitted for review.');
    }

    public function approve(Request $request, HousingApplication $application): RedirectResponse
    {
        $this->authorize('review', $application);

        $validated = $request->validate([
            'assigned_officer_id' => ['nullable', 'exists:users,id'],
        ]);

        $application->update([
            'status' => ApplicationStatus::Approved,
            'assigned_officer_id' => $validated['assigned_officer_id'] ?? $request->user()->id,
            'reviewed_at' => now(),
            'approved_at' => now(),
            'rejection_remarks' => null,
        ]);

        $this->auditLog->log('application.approved', "Application {$application->application_number} approved.", $application);
        $application->beneficiary->notify(new ApplicationStatusNotification($application, 'Your housing application has been approved.'));

        return back()->with('status', 'Application approved.');
    }

    public function reject(Request $request, HousingApplication $application): RedirectResponse
    {
        $this->authorize('review', $application);

        $validated = $request->validate([
            'rejection_remarks' => ['required', 'string', 'max:2000'],
        ]);

        $application->update([
            'status' => ApplicationStatus::Rejected,
            'rejected_at' => now(),
            'reviewed_at' => now(),
            'rejection_remarks' => $validated['rejection_remarks'],
        ]);

        $this->auditLog->log('application.rejected', "Application {$application->application_number} rejected.", $application, $validated);
        $application->beneficiary->notify(new ApplicationStatusNotification($application, 'Your housing application was rejected: '.$validated['rejection_remarks']));

        return back()->with('status', 'Application rejected with remarks.');
    }

    public function destroy(HousingApplication $application): RedirectResponse
    {
        $this->authorize('delete', $application);

        $number = $application->application_number;
        $application->delete();

        $this->auditLog->log('application.deleted', "Application {$number} deleted.");

        return redirect()->route('applications.index')->with('status', 'Application deleted.');
    }
}
