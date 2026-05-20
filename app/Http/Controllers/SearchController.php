<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Grievance;
use App\Models\HousingApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = $request->string('q')->trim()->toString();
        $results = [
            'applications' => collect(),
            'grievances' => collect(),
            'beneficiaries' => collect(),
        ];

        if (strlen($query) >= 2) {
            $appQuery = HousingApplication::query()
                ->with(['beneficiary', 'scheme'])
                ->where('application_number', 'like', "%{$query}%")
                ->orWhereHas('beneficiary', fn ($b) => $b->where('name', 'like', "%{$query}%")
                    ->orWhere('unique_user_id', 'like', "%{$query}%"));

            if ($request->user()->isCustomer()) {
                $appQuery->where('user_id', $request->user()->id);
            }

            $results['applications'] = $appQuery->limit(10)->get();

            $grievanceQuery = Grievance::query()
                ->where('reference_number', 'like', "%{$query}%")
                ->orWhere('subject', 'like', "%{$query}%");

            if ($request->user()->isCustomer()) {
                $grievanceQuery->where('user_id', $request->user()->id);
            }

            $results['grievances'] = $grievanceQuery->limit(10)->get();

            if ($request->user()->isStaff()) {
                $results['beneficiaries'] = User::query()
                    ->where('role', UserRole::Customer)
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                            ->orWhere('unique_user_id', 'like', "%{$query}%")
                            ->orWhere('aadhaar_number', 'like', "%{$query}%");
                    })
                    ->limit(10)
                    ->get();
            }
        }

        return view('mis.search.index', compact('query', 'results'));
    }
}
