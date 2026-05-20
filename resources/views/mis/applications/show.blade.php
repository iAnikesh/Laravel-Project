<x-mis-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('applications.index') }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-700 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            {{ $application->application_number }}
        </div>
    </x-slot>
    <x-slot name="subheader">{{ $application->scheme->name }} · {{ $application->village->block->district->name }}</x-slot>

    <div class="mb-6 flex flex-wrap items-center gap-4 p-4 rounded-2xl glass-card bg-white/60">
        <x-mis.status-badge :status="$application->status" />
        <div class="flex items-center gap-2 flex-1 max-w-sm">
            <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Progress</span>
            <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-200/60 shadow-inner">
                <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 shadow-[0_0_8px_rgba(52,211,153,0.5)]" style="width: {{ $application->completion_percentage }}%"></div>
            </div>
            <span class="text-xs font-bold text-emerald-700">{{ $application->completion_percentage }}%</span>
        </div>
        @can('update', $application)
            <a href="{{ route('applications.edit', $application) }}" class="ml-auto mis-btn-secondary text-xs px-3 py-1.5 h-auto">Edit Application</a>
        @endcan
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <section class="mis-card relative overflow-hidden">
                <div class="absolute -top-32 -right-32 h-64 w-64 rounded-full bg-blue-400/10 blur-[60px] pointer-events-none"></div>
                <div class="mis-card-header border-b border-white/50 bg-transparent">
                    <h2 class="font-bold text-slate-900 text-lg">Application Details</h2>
                </div>
                <div class="mis-card-body relative z-10">
                    <dl class="grid gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div class="bg-white/40 p-4 rounded-xl border border-white/50"><dt class="text-xs text-slate-500 uppercase font-semibold tracking-wider mb-1">Beneficiary</dt><dd class="font-bold text-slate-900 text-[15px]">{{ $application->beneficiary->name }}</dd></div>
                        <div class="bg-white/40 p-4 rounded-xl border border-white/50"><dt class="text-xs text-slate-500 uppercase font-semibold tracking-wider mb-1">User ID</dt><dd class="font-bold text-slate-900 text-[15px]">{{ $application->beneficiary->unique_user_id ?? '—' }}</dd></div>
                        <div class="bg-white/40 p-4 rounded-xl border border-white/50"><dt class="text-xs text-slate-500 uppercase font-semibold tracking-wider mb-1">Village</dt><dd class="font-medium text-slate-800">{{ $application->village->name }}</dd></div>
                        <div class="bg-white/40 p-4 rounded-xl border border-white/50"><dt class="text-xs text-slate-500 uppercase font-semibold tracking-wider mb-1">Site Address</dt><dd class="font-medium text-slate-800">{{ $application->site_address ?? '—' }}</dd></div>
                        @if ($application->latitude && $application->longitude)
                            <div class="sm:col-span-2 bg-white/40 p-4 rounded-xl border border-white/50"><dt class="text-xs text-slate-500 uppercase font-semibold tracking-wider mb-1">GIS Coordinates</dt><dd class="font-medium text-slate-800 font-mono text-sm flex items-center gap-2"><svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ $application->latitude }}, {{ $application->longitude }}</dd></div>
                        @endif
                        @if ($application->rejection_remarks)
                            <div class="sm:col-span-2 bg-red-50/50 p-4 rounded-xl border border-red-100"><dt class="text-xs text-red-600 uppercase font-semibold tracking-wider mb-1">Rejection Remarks</dt><dd class="font-bold text-red-800">{{ $application->rejection_remarks }}</dd></div>
                        @endif
                    </dl>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @if ($application->status === \App\Enums\ApplicationStatus::Draft && auth()->id() === $application->user_id)
                            <form method="POST" action="{{ route('applications.submit', $application) }}">@csrf<button type="submit" class="mis-btn-primary w-auto px-6"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg> Submit for review</button></form>
                        @endif
                        @can('review', $application)
                            @if (in_array($application->status, [\App\Enums\ApplicationStatus::Submitted, \App\Enums\ApplicationStatus::UnderReview]))
                                <form method="POST" action="{{ route('applications.approve', $application) }}" class="inline">@csrf<button type="submit" class="mis-btn-primary"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Approve</button></form>
                                <button type="button" onclick="document.getElementById('reject-form').classList.toggle('hidden')" class="mis-btn-danger"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Reject</button>
                            @endif
                        @endcan
                    </div>
                    @can('review', $application)
                        <form id="reject-form" method="POST" action="{{ route('applications.reject', $application) }}" class="mt-4 hidden space-y-3 bg-red-50/50 p-5 rounded-xl border border-red-100">@csrf
                            <textarea name="rejection_remarks" class="mis-input !bg-white/80" rows="2" placeholder="Rejection remarks (required)" required></textarea>
                            <button type="submit" class="mis-btn-danger">Confirm reject</button>
                        </form>
                    @endcan
                </div>
            </section>

            @if (auth()->user()->isStaff() && in_array($application->status, [\App\Enums\ApplicationStatus::Approved, \App\Enums\ApplicationStatus::InProgress, \App\Enums\ApplicationStatus::Completed]))
                <section class="mis-card relative overflow-hidden">
                    <div class="mis-card-header border-b border-white/50 bg-transparent">
                        <h2 class="font-bold text-slate-900 text-lg">Record Construction Progress</h2>
                    </div>
                    <div class="mis-card-body relative z-10">
                        <form method="POST" action="{{ route('applications.progress.store', $application) }}" class="mt-2 grid gap-4 sm:grid-cols-3">@csrf
                            <div>
                                <label class="mis-label">Stage</label>
                                <select name="stage" class="mis-input mt-1.5" required>
                                    @foreach (\App\Enums\ProgressStage::cases() as $stage)
                                        <option value="{{ $stage->value }}">{{ $stage->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="mis-label">Completion %</label>
                                <input type="number" name="percentage" min="0" max="100" class="mis-input mt-1.5" required>
                            </div>
                            <div class="sm:col-span-3">
                                <label class="mis-label">Notes</label>
                                <input type="text" name="notes" class="mis-input mt-1.5" placeholder="Optional notes about the progress">
                            </div>
                            <button type="submit" class="mis-btn-primary w-auto px-6 sm:col-span-3 mt-2"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Record Progress</button>
                        </form>

                        @if($application->progressEntries->isNotEmpty())
                            <div class="mt-8 border-t border-white/50 pt-6">
                                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4">Progress History</h3>
                                <div class="space-y-3">
                                    @foreach ($application->progressEntries as $entry)
                                        <div class="flex items-center justify-between bg-white/40 p-3 rounded-xl border border-white/50">
                                            <div class="flex items-center gap-3">
                                                <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-900 text-sm">{{ $entry->stage->label() }}</p>
                                                    <p class="text-xs text-slate-500">{{ $entry->notes ?? 'No notes' }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-block px-2 py-1 rounded bg-emerald-50 text-emerald-700 font-bold text-xs">{{ $entry->percentage }}%</span>
                                                <p class="text-xs text-slate-400 mt-1">{{ $entry->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            @endif
        </div>

        <div class="space-y-6">
            @if (auth()->user()->isStaff())
                <section class="mis-card">
                    <div class="mis-card-header border-b border-white/50 bg-transparent">
                        <h2 class="font-bold text-slate-900 text-lg">Financial Records</h2>
                    </div>
                    <div class="mis-card-body">
                        <form method="POST" action="{{ route('applications.financials.store', $application) }}" class="mt-2 grid gap-4">@csrf
                            <div>
                                <label class="mis-label">Type</label>
                                <select name="type" class="mis-input mt-1.5" required>
                                    @foreach (\App\Enums\FinancialRecordType::cases() as $type)
                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div><label class="mis-label">Amount (₹)</label><input type="number" step="0.01" name="amount" class="mis-input mt-1.5" required></div>
                            <div><label class="mis-label">Transaction Date</label><input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="mis-input mt-1.5" required></div>
                            <div><label class="mis-label">Reference #</label><input type="text" name="reference_number" class="mis-input mt-1.5"></div>
                            <div><label class="mis-label">Description</label><input type="text" name="description" class="mis-input mt-1.5"></div>
                            <button type="submit" class="mis-btn-primary w-full mt-2"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Add Record</button>
                        </form>
                        
                        @if($application->financialRecords->isNotEmpty())
                            <div class="mt-6 border-t border-white/50 pt-5">
                                <ul class="space-y-3 text-sm">
                                    @foreach ($application->financialRecords as $record)
                                        <li class="rounded-xl border border-white/50 bg-white/40 p-3">
                                            <div class="flex justify-between items-start">
                                                <span class="font-bold text-slate-800">{{ $record->type->label() }}</span>
                                                <span class="font-bold text-emerald-700">₹{{ number_format($record->amount, 2) }}</span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-1">{{ $record->transaction_date->format('d M Y') }} · {{ $record->reference_number ?? 'No ref' }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <section class="mis-card">
                <div class="mis-card-header border-b border-white/50 bg-transparent">
                    <h2 class="font-bold text-slate-900 text-lg">Documents</h2>
                </div>
                <div class="mis-card-body">
                    <form method="POST" action="{{ route('applications.documents.store', $application) }}" enctype="multipart/form-data" class="mt-2 space-y-4">@csrf
                        <div>
                            <input type="file" name="file" class="mis-input py-2.5 text-sm file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" required>
                        </div>
                        <div>
                            <select name="category" class="mis-input" required>
                                <option value="identity">Identity proof</option>
                                <option value="site_photo">Site photo</option>
                                <option value="progress_photo">Progress photo</option>
                                <option value="financial">Financial document</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <button type="submit" class="mis-btn-primary w-full mt-2"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg> Upload Document</button>
                    </form>
                    
                    @if($application->documents->isNotEmpty())
                        <div class="mt-6 border-t border-white/50 pt-5">
                            <ul class="space-y-2 text-sm">
                                @foreach ($application->documents as $doc)
                                    <li class="flex items-center justify-between gap-3 p-3 rounded-xl border border-white/50 bg-white/40 hover:bg-white/60 transition">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <svg class="h-8 w-8 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <div class="min-w-0">
                                                <p class="truncate font-semibold text-slate-800 text-[13px]">{{ $doc->name }}</p>
                                                <p class="text-[11px] text-slate-500 uppercase">{{ $doc->category }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('documents.download', $doc) }}" class="shrink-0 p-2 text-emerald-600 hover:text-emerald-700 bg-emerald-50 rounded-lg transition" title="Download">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-mis-layout>
