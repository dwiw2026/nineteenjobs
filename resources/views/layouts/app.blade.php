<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'NineteenJobs'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-[#f5f7f3] text-[#19251d] antialiased" style="font-family: 'Instrument Sans', sans-serif;">

    {{-- Mobile sidebar overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-20 bg-black/40 hidden lg:hidden"></div>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 -translate-x-full border-r border-[#e0e8df] bg-white px-5 py-6 transition-transform duration-300 lg:translate-x-0">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <div class="grid size-8 place-items-center rounded-xl bg-[#b7f34a] text-[#12210d]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                </div>
                <span class="text-lg font-bold tracking-[-0.04em]">nineteen<span class="text-[#82b72d]">jobs</span></span>
            </a>

            {{-- Navigation --}}
            <p class="mb-4 mt-10 px-3 text-[10px] font-bold uppercase tracking-[.18em] text-[#a0aaa1]">Workspace</p>
            <nav class="space-y-1">
                @php
                    $authUser  = auth()->user();
                    $company   = $authUser?->company;

                    if ($authUser?->isEmployer()) {
                        // Build company URL: go to edit if company exists, else create
                        $companyUrl = $company
                            ? route('employer.company.edit', $company)
                            : route('employer.company.create');

                        $navItems = [
                            ['label' => 'Overview',       'icon' => 'layout-dashboard', 'url' => route('dashboard')],
                            ['label' => 'Lowongan Saya',  'icon' => 'briefcase',        'url' => route('employer.jobs.index')],
                            ['label' => 'Pelamar',        'icon' => 'users',            'url' => route('employer.applications.index')],
                            ['label' => 'Perusahaan',     'icon' => 'building-2',       'url' => $companyUrl],
                        ];
                    } elseif ($authUser?->isAdmin()) {
                        $navItems = [
                            ['label' => 'Overview',       'icon' => 'layout-dashboard', 'url' => route('dashboard')],
                            ['label' => 'Semua Lowongan', 'icon' => 'briefcase',        'url' => route('jobs.index')],
                            ['label' => 'Pengguna',       'icon' => 'users',            'url' => route('dashboard')],
                        ];
                    } else {
                        $navItems = [
                            ['label' => 'Overview',       'icon' => 'layout-dashboard', 'url' => route('dashboard')],
                            ['label' => 'Lowongan',       'icon' => 'briefcase',        'url' => route('jobs.index')],
                            ['label' => 'Match Saya',     'icon' => 'target',           'url' => route('matches.index')],
                            ['label' => 'Lamaran',        'icon' => 'file-text',        'url' => route('applications.index')],
                            ['label' => 'Career Agent',   'icon' => 'message-circle',   'url' => route('agent.chat')],
                        ];
                    }
                @endphp

                @foreach ($navItems as $item)
                    @php $isActive = request()->url() === $item['url'] || str_starts_with(request()->url(), $item['url'] . '/') @endphp
                    <a href="{{ $item['url'] }}"
                       class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition {{ $isActive ? 'bg-[#eaf8ce] text-[#5f8a25]' : 'text-[#7b877d] hover:bg-[#f5f8f2]' }}">
                        @include('components.icons.' . $item['icon'], ['size' => 18])
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <a href="{{ route('profile.edit') }}"
                   class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-[#7b877d] hover:bg-[#f5f8f2] transition">
                    @include('components.icons.settings', ['size' => 18])
                    Pengaturan
                </a>
            </nav>

            {{-- AI Agent status card --}}
            <div class="absolute bottom-6 left-5 right-5 rounded-2xl bg-[#eff9db] p-4">
                <div class="flex items-center gap-2 text-xs font-bold text-[#62852e]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                    AI AGENT
                </div>
                <p class="mt-2 text-xs leading-5 text-[#748168]">Career Agent aktif dan siap menjawab 24/7.</p>
                <div class="mt-3 flex items-center gap-1.5 text-[10px] font-bold text-[#78a332]">
                    <span class="size-1.5 rounded-full bg-[#8cc532]"></span>
                    System operational
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex flex-1 flex-col lg:pl-64">
            {{-- Top header --}}
            <header class="flex h-20 items-center justify-between border-b border-[#e2e9e0] bg-white px-5 lg:px-10">
                <div class="flex items-center gap-3">
                    <button id="sidebar-toggle" class="lg:hidden" aria-label="Open menu">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
                    </button>
                    <div>
                        <p class="text-xs text-[#89958b]">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <h1 class="mt-1 text-xl font-semibold tracking-[-0.03em]">@yield('page-title', 'Dashboard')</h1>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button class="grid size-10 place-items-center rounded-full border border-[#e0e8df] text-[#7e8a80]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    </button>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 rounded-full bg-[#f0f5ec] py-1.5 pl-1.5 pr-3 text-xs font-bold">
                            <div class="grid size-7 place-items-center rounded-full bg-[#1d3024] text-[10px] text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 rounded-xl border border-[#e0e8df] bg-white p-2 shadow-lg z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-[#647066] hover:bg-[#f5f8f2]">Profil Saya</a>
                            <hr class="my-1 border-[#e8ede6]">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-red-500 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 p-5 lg:p-10">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebar-toggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        });
        document.getElementById('sidebar-overlay')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.add('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
