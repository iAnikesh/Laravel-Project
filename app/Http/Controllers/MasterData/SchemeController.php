<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Scheme;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchemeController extends Controller
{
    public function __construct(protected AuditLogService $auditLog) {}

    public function index(): View
    {
        $schemes = Scheme::query()->withCount('housingApplications')->orderBy('name')->paginate(12);

        return view('mis.master-data.schemes.index', compact('schemes'));
    }

    public function create(): View
    {
        return view('mis.master-data.schemes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'code' => ['required', 'string', 'max:30', 'unique:schemes,code'],
            'category' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'budget_allocated' => ['required', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $scheme = Scheme::query()->create($validated);

        $this->auditLog->log('master_data.scheme_created', "Scheme {$scheme->name} created.", $scheme);

        return redirect()->route('master.schemes.index')->with('status', 'Scheme created.');
    }
}
