<?php

namespace App\Http\Controllers;

use App\Enums\GrievanceStatus;
use App\Models\Grievance;
use App\Models\HousingApplication;
use App\Services\AuditLogService;
use App\Services\ReferenceNumberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GrievanceController extends Controller
{
    public function __construct(
        protected AuditLogService $auditLog,
        protected ReferenceNumberService $references,
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Grievance::class);

        $query = Grievance::query()->with(['user', 'housingApplication', 'assignedOfficer']);

        if ($request->user()->isCustomer()) {
            $query->where('user_id', $request->user()->id);
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        $grievances = $query->latest()->paginate(12)->withQueryString();

        return view('mis.grievances.index', [
            'grievances' => $grievances,
            'statuses' => GrievanceStatus::cases(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Grievance::class);

        $applications = HousingApplication::query()
            ->when(auth()->user()->isCustomer(), fn ($q) => $q->where('user_id', auth()->id()))
            ->latest()
            ->get();

        return view('mis.grievances.create', compact('applications'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Grievance::class);

        $validated = $request->validate([
            'housing_application_id' => ['nullable', 'exists:housing_applications,id'],
            'subject' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:5000'],
        ]);

        $grievance = Grievance::query()->create([
            ...$validated,
            'reference_number' => $this->references->grievance(),
            'user_id' => $request->user()->id,
            'status' => GrievanceStatus::Open,
        ]);

        $this->auditLog->log('grievance.created', "Grievance {$grievance->reference_number} submitted.", $grievance);

        return redirect()->route('grievances.show', $grievance)->with('status', 'Grievance submitted successfully.');
    }

    public function show(Grievance $grievance): View
    {
        $this->authorize('view', $grievance);

        $grievance->load(['user', 'housingApplication', 'assignedOfficer']);

        return view('mis.grievances.show', compact('grievance'));
    }

    public function respond(Request $request, Grievance $grievance): RedirectResponse
    {
        $this->authorize('respond', $grievance);

        $validated = $request->validate([
            'admin_response' => ['required', 'string', 'max:5000'],
            'status' => ['required', 'string'],
        ]);

        $status = GrievanceStatus::from($validated['status']);

        $grievance->update([
            'admin_response' => $validated['admin_response'],
            'status' => $status,
            'assigned_to' => $request->user()->id,
            'resolved_at' => in_array($status, [GrievanceStatus::Resolved, GrievanceStatus::Closed], true) ? now() : null,
        ]);

        $this->auditLog->log('grievance.responded', "Grievance {$grievance->reference_number} updated to {$status->label()}.", $grievance);

        return back()->with('status', 'Grievance response saved.');
    }
}
