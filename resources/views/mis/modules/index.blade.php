<x-mis-layout>
    <x-slot name="header">MIS Modules</x-slot>
    <x-slot name="subheader">Complete feature architecture for rural housing scheme management</x-slot>

    @php
        $modules = [
            ['row' => 'Foundation', 'accent' => 'emerald', 'items' => [
                ['title' => 'Data Collection', 'points' => ['Online forms & surveys', 'File / document uploads', 'Excel / CSV import']],
                ['title' => 'Data Storage', 'points' => ['Structured MySQL database', 'Record management (CRUD)', 'Data validation & integrity']],
                ['title' => 'User Management', 'points' => ['Login / logout / authentication', 'Role-based access control', 'Profile management'], 'route' => 'profile.edit'],
            ]],
            ['row' => 'Insights', 'accent' => 'blue', 'items' => [
                ['title' => 'Dashboard', 'points' => ['Summary count cards', 'Charts & graphs', 'Recent activity feed'], 'route' => 'dashboard'],
                ['title' => 'Search & Filter', 'points' => ['Search by name / ID', 'Filter by date or status', 'Sort & paginate results'], 'route' => 'search'],
                ['title' => 'Reports', 'points' => ['Generate PDF reports', 'Export Excel / CSV', 'Print-friendly views'], 'route' => 'reports.index', 'staff' => true],
            ]],
            ['row' => 'Process', 'accent' => 'violet', 'items' => [
                ['title' => 'Workflow / Approval', 'points' => ['Submit → Review → Approve', 'Status tracking', 'Reject with remarks'], 'route' => 'applications.index'],
                ['title' => 'Notifications', 'points' => ['In-app alerts', 'Email notifications', 'Status change alerts'], 'route' => 'notifications.index'],
                ['title' => 'Audit Trail / Logs', 'points' => ['Who did what & when', 'Login history', 'Change log records'], 'route' => 'audit-logs.index', 'admin' => true],
            ]],
            ['row' => 'Geospatial', 'accent' => 'amber', 'items' => [
                ['title' => 'Master Data', 'points' => ['Districts / blocks / villages', 'Scheme & category lists', 'Configurable dropdowns'], 'route' => 'master.districts.index', 'admin' => true],
                ['title' => 'GIS / Maps', 'points' => ['Location pinning on map', 'Heatmap / density views', 'Leaflet.js integration'], 'route' => 'gis.index'],
                ['title' => 'File Management', 'points' => ['Upload / view / download', 'Photos & documents', 'Per-record file storage'], 'route' => 'applications.index'],
            ]],
            ['row' => 'Monitoring', 'accent' => 'rose', 'items' => [
                ['title' => 'Progress Tracking', 'points' => ['Stage-wise updates', 'Percentage completion', 'Timeline / history view'], 'route' => 'applications.index'],
                ['title' => 'Grievance / Complaints', 'points' => ['Submit complaint forms', 'Admin response system', 'Open / resolved status'], 'route' => 'grievances.index'],
                ['title' => 'Financial Tracking', 'points' => ['Budget allocation', 'Installment / payment logs', 'Expenditure summaries'], 'route' => 'applications.index'],
            ]],
        ];
        $accentBorder = [
            'emerald' => 'border-t-emerald-500',
            'blue' => 'border-t-blue-500',
            'violet' => 'border-t-violet-500',
            'amber' => 'border-t-amber-500',
            'rose' => 'border-t-rose-500',
        ];
    @endphp

    @foreach ($modules as $section)
        <section class="mb-10">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">{{ $section['row'] }}</h2>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($section['items'] as $module)
                    @php
                        $canAccess = true;
                        if (! empty($module['admin'])) {
                            $canAccess = auth()->user()->isAdmin();
                        } elseif (! empty($module['staff'])) {
                            $canAccess = auth()->user()->isStaff();
                        }
                    @endphp
                    <article class="mis-module-card border-t-4 {{ $accentBorder[$section['accent']] }}">
                        <h3 class="mis-module-card-title">{{ $module['title'] }}</h3>
                        <ul class="mt-3 space-y-2 text-sm text-slate-600">
                            @foreach ($module['points'] as $point)
                                <li class="flex items-start gap-2">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $point }}
                                </li>
                            @endforeach
                        </ul>
                        @if (isset($module['route']) && Route::has($module['route']) && $canAccess)
                            <a href="{{ route($module['route']) }}" class="mis-link mt-4 inline-flex text-sm">Open module →</a>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endforeach
</x-mis-layout>
