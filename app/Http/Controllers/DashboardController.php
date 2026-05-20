<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Enums\GrievanceStatus;
use App\Enums\UserRole;
use App\Models\AuditLog;
use App\Models\FinancialRecord;
use App\Models\Grievance;
use App\Models\HousingApplication;
use App\Models\Scheme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $applicationQuery = HousingApplication::query();
        $grievanceQuery = Grievance::query();

        if ($user->isCustomer()) {
            $applicationQuery->where('user_id', $user->id);
            $grievanceQuery->where('user_id', $user->id);
        } elseif ($user->isOfficer()) {
            $applicationQuery->where(function ($q) use ($user) {
                $q->where('assigned_officer_id', $user->id)
                    ->orWhereIn('status', [
                        ApplicationStatus::Submitted->value,
                        ApplicationStatus::UnderReview->value,
                    ]);
            });
        }

        $stats = [
            'total_applications' => (clone $applicationQuery)->count(),
            'pending_review' => (clone $applicationQuery)->whereIn('status', [
                ApplicationStatus::Submitted,
                ApplicationStatus::UnderReview,
            ])->count(),
            'in_progress' => (clone $applicationQuery)->where('status', ApplicationStatus::InProgress)->count(),
            'completed' => (clone $applicationQuery)->where('status', ApplicationStatus::Completed)->count(),
            'open_grievances' => (clone $grievanceQuery)->whereIn('status', [
                GrievanceStatus::Open,
                GrievanceStatus::InProgress,
            ])->count(),
            'active_schemes' => Scheme::query()->where('is_active', true)->count(),
            'total_expenditure' => $user->isCustomer()
                ? 0
                : FinancialRecord::query()->sum('amount'),
            'beneficiaries' => $user->isAdmin()
                ? User::query()->where('role', UserRole::Customer)->count()
                : 0,
        ];

        $statusBreakdown = (clone $applicationQuery)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $recentApplications = (clone $applicationQuery)
            ->with(['beneficiary', 'scheme', 'village.block.district'])
            ->latest()
            ->limit(5)
            ->get();

        $recentActivity = $user->isAdmin()
            ? AuditLog::query()->with('user')->latest()->limit(8)->get()
            : collect();

        return view('mis.dashboard', compact('stats', 'statusBreakdown', 'recentApplications', 'recentActivity'));
    }
}
