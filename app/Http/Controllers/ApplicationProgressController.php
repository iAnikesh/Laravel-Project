<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Enums\ProgressStage;
use App\Models\ApplicationProgress;
use App\Models\HousingApplication;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicationProgressController extends Controller
{
    public function __construct(protected AuditLogService $auditLog) {}

    public function store(Request $request, HousingApplication $application): RedirectResponse
    {
        $this->authorize('update', $application);

        abort_unless($request->user()->isStaff() || $application->status === ApplicationStatus::InProgress, 403);

        $validated = $request->validate([
            'stage' => ['required', 'string'],
            'percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $stage = ProgressStage::from($validated['stage']);

        ApplicationProgress::query()->create([
            'housing_application_id' => $application->id,
            'stage' => $stage,
            'percentage' => $validated['percentage'],
            'notes' => $validated['notes'] ?? null,
            'recorded_by' => $request->user()->id,
        ]);

        $newStatus = $validated['percentage'] >= 100
            ? ApplicationStatus::Completed
            : ApplicationStatus::InProgress;

        $application->update([
            'current_stage' => $stage,
            'completion_percentage' => $validated['percentage'],
            'status' => in_array($application->status, [ApplicationStatus::Approved, ApplicationStatus::InProgress, ApplicationStatus::Completed], true)
                ? $newStatus
                : $application->status,
        ]);

        $this->auditLog->log(
            'progress.recorded',
            "Progress updated to {$stage->label()} ({$validated['percentage']}%) for {$application->application_number}.",
            $application,
        );

        return back()->with('status', 'Construction progress recorded.');
    }
}
