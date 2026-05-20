<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function __invoke(Request $request): View
    {
        abort_unless($request->user()->isAdmin(), 403);

        $logs = AuditLog::query()
            ->with('user')
            ->when($request->string('action')->toString(), fn ($q, $action) => $q->where('action', 'like', "%{$action}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('mis.audit-logs.index', compact('logs'));
    }
}
