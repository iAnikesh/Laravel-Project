<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\District;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DistrictController extends Controller
{
    public function __construct(protected AuditLogService $auditLog) {}

    public function index(): View
    {
        $districts = District::query()->withCount(['blocks'])->orderBy('name')->paginate(15);

        return view('mis.master-data.districts.index', compact('districts'));
    }

    public function create(): View
    {
        return view('mis.master-data.districts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:20', 'unique:districts,code'],
            'state' => ['required', 'string', 'max:100'],
        ]);

        $district = District::query()->create($validated);

        $this->auditLog->log('master_data.district_created', "District {$district->name} created.", $district);

        return redirect()->route('master.districts.index')->with('status', 'District created.');
    }

    public function blocks(District $district): JsonResponse
    {
        return response()->json(
            $district->blocks()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'code']),
        );
    }

    public function villages(Block $block): JsonResponse
    {
        return response()->json(
            $block->villages()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'code']),
        );
    }
}
