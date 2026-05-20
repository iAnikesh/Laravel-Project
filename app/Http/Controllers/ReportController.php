<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Models\HousingApplication;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->isStaff(), 403);

        $byScheme = HousingApplication::query()
            ->selectRaw('scheme_id, status, count(*) as total')
            ->groupBy('scheme_id', 'status')
            ->with('scheme')
            ->get()
            ->groupBy(fn ($row) => $row->scheme->name);

        $summary = [
            'total' => HousingApplication::count(),
            'approved' => HousingApplication::where('status', ApplicationStatus::Approved)->count(),
            'completed' => HousingApplication::where('status', ApplicationStatus::Completed)->count(),
            'rejected' => HousingApplication::where('status', ApplicationStatus::Rejected)->count(),
        ];

        $schemes = Scheme::query()->orderBy('name')->get();

        return view('mis.reports.index', compact('byScheme', 'summary', 'schemes'));
    }

    public function export(Request $request): Response
    {
        abort_unless($request->user()->isStaff(), 403);

        $applications = HousingApplication::query()
            ->with(['beneficiary', 'scheme', 'village'])
            ->when($request->integer('scheme_id'), fn ($q, $id) => $q->where('scheme_id', $id))
            ->get();

        $csv = "Application Number,Beneficiary,Scheme,Village,Status,Completion %,Submitted At\n";

        foreach ($applications as $app) {
            $csv .= implode(',', [
                $app->application_number,
                '"'.$app->beneficiary->name.'"',
                '"'.$app->scheme->name.'"',
                '"'.$app->village->name.'"',
                $app->status->value,
                $app->completion_percentage,
                $app->submitted_at?->toDateString() ?? '',
            ])."\n";
        }

        return ResponseFactory::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="housing-applications-'.now()->format('Y-m-d').'.csv"',
        ]);
    }
}
