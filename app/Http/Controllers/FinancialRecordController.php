<?php

namespace App\Http\Controllers;

use App\Enums\FinancialRecordType;
use App\Models\FinancialRecord;
use App\Models\HousingApplication;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FinancialRecordController extends Controller
{
    public function __construct(protected AuditLogService $auditLog) {}

    public function store(Request $request, HousingApplication $application): RedirectResponse
    {
        abort_unless($request->user()->isStaff(), 403);

        $validated = $request->validate([
            'type' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'transaction_date' => ['required', 'date'],
        ]);

        $record = FinancialRecord::query()->create([
            ...$validated,
            'type' => FinancialRecordType::from($validated['type']),
            'housing_application_id' => $application->id,
            'recorded_by' => $request->user()->id,
        ]);

        $this->auditLog->log(
            'financial.recorded',
            "Financial record ({$record->type->label()}) of ₹{$record->amount} added to {$application->application_number}.",
            $application,
        );

        return back()->with('status', 'Financial record added.');
    }
}
