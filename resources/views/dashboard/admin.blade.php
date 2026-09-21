@extends('layouts.app')

@section('title', 'Dashboard — NineteenJobs')
@section('page-title', 'Platform pulse')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <p class="text-xs font-bold uppercase tracking-[.16em] text-[#82b52f]">Overview</p>
        <h2 class="mt-2 text-3xl font-semibold tracking-[-0.05em]">Platform pulse</h2>
    </div>
    <span class="hidden items-center gap-2 rounded-xl border border-[#dce6d9] bg-white px-4 py-2.5 text-sm font-semibold text-[#627064] sm:flex">
        <span class="size-2 rounded-full bg-[#91c83a]"></span> Live data
    </span>
</div>

{{-- Stats --}}
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-5">
        <div class="flex items-center justify-between">
            <div class="grid size-9 place-items-center rounded-xl bg-[#eff8dc] text-[#78a92f]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span class="rounded-full bg-[#edf8d7] px-2 py-1 text-[10px] font-bold text-[#70a02e]">+{{ $stats['talent_growth'] ?? '12.8' }}%</span>
        </div>
        <p class="mt-5 text-2xl font-semibold tracking-[-0.05em]">{{ number_format($stats['total_talents'] ?? 0) }}</p>
        <p class="mt-1 text-xs text-[#89958b]">Total talent</p>
    </div>
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-5">
        <div class="flex items-center justify-between">
            <div class="grid size-9 place-items-center rounded-xl bg-[#eff8dc] text-[#78a92f]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <span class="rounded-full bg-[#edf8d7] px-2 py-1 text-[10px] font-bold text-[#70a02e]">+{{ $stats['job_growth'] ?? '8.4' }}%</span>
        </div>
        <p class="mt-5 text-2xl font-semibold tracking-[-0.05em]">{{ number_format($stats['active_jobs'] ?? 0) }}</p>
        <p class="mt-1 text-xs text-[#89958b]">Active jobs</p>
    </div>
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-5">
        <div class="flex items-center justify-between">
            <div class="grid size-9 place-items-center rounded-xl bg-[#eff8dc] text-[#78a92f]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
            </div>
            <span class="rounded-full bg-[#edf8d7] px-2 py-1 text-[10px] font-bold text-[#70a02e]">+{{ $stats['match_growth'] ?? '18.2' }}%</span>
        </div>
        <p class="mt-5 text-2xl font-semibold tracking-[-0.05em]">{{ number_format($stats['total_matches'] ?? 0) }}</p>
        <p class="mt-1 text-xs text-[#89958b]">Successful matches</p>
    </div>
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-5">
        <div class="flex items-center justify-between">
            <div class="grid size-9 place-items-center rounded-xl bg-[#eff8dc] text-[#78a92f]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
            </div>
            <span class="rounded-full bg-[#edf8d7] px-2 py-1 text-[10px] font-bold text-[#70a02e]">+{{ $stats['company_growth'] ?? '6.1' }}%</span>
        </div>
        <p class="mt-5 text-2xl font-semibold tracking-[-0.05em]">{{ number_format($stats['verified_companies'] ?? 0) }}</p>
        <p class="mt-1 text-xs text-[#89958b]">Verified companies</p>
    </div>
</div>

{{-- Charts row --}}
<div class="mt-6 grid gap-6 xl:grid-cols-[1.45fr_1fr]">
    {{-- Activity chart --}}
    <section class="rounded-2xl border border-[#e1e9df] bg-white p-5 lg:p-6">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="font-semibold">Platform activity</h3>
                <p class="mt-1 text-xs text-[#89958b]">Applications & successful matches</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#85b52f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
        </div>
        <div class="mt-8 flex h-48 items-end gap-2 sm:gap-4">
            @foreach([38,52,43,68,56,73,62,81,70,92,78,88] as $i => $height)
            <div class="flex flex-1 flex-col items-center gap-2">
                <div class="w-full rounded-t-md {{ $i === 9 ? 'bg-[#9bd63e]' : 'bg-[#e2f0ca]' }}" style="height: {{ $height }}%"></div>
                <span class="text-[10px] text-[#9aa59c]">{{ ['Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des','Jan','Feb','Mar','Apr'][$i] }}</span>
            </div>
            @endforeach
        </div>
    </section>

    {{-- AI Matching Quality --}}
    <section class="rounded-2xl border border-[#e1e9df] bg-white p-5 lg:p-6">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="font-semibold">AI matching quality</h3>
                <p class="mt-1 text-xs text-[#89958b]">Average score this month</p>
            </div>
            <div class="grid size-9 place-items-center rounded-xl bg-[#eff9da] text-[#78a82d]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
            </div>
        </div>
        <div class="mt-8 flex items-center gap-6">
            <div class="relative grid size-32 shrink-0 place-items-center rounded-full" style="background: conic-gradient(#9bd63e 0 91%, #edf1ea 91% 100%)">
                <div class="grid size-24 place-items-center rounded-full bg-white">
                    <span class="text-3xl font-semibold tracking-[-0.06em]">91<span class="text-base">%</span></span>
                </div>
            </div>
            <div class="space-y-3 text-xs">
                <p class="flex items-center gap-2 text-[#68766b]"><span class="size-2 rounded-full bg-[#9bd63e]"></span> Strong fit <b class="ml-auto text-[#27382a]">72%</b></p>
                <p class="flex items-center gap-2 text-[#68766b]"><span class="size-2 rounded-full bg-[#d5eab0]"></span> Potential <b class="ml-auto text-[#27382a]">19%</b></p>
                <p class="flex items-center gap-2 text-[#68766b]"><span class="size-2 rounded-full bg-[#edf1ea]"></span> Low fit <b class="ml-auto text-[#27382a]">9%</b></p>
            </div>
        </div>
    </section>
</div>

{{-- Recent activity row --}}
<div class="mt-6 grid gap-6 xl:grid-cols-[1.45fr_1fr]">
    {{-- Recent Jobs --}}
    <section class="rounded-2xl border border-[#e1e9df] bg-white p-5 lg:p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold">Recent job activity</h3>
                <p class="mt-1 text-xs text-[#89958b]">Latest listings and their status</p>
            </div>
            <a href="{{ route('admin.jobs.index') }}" class="text-xs font-bold text-[#78a52e]">View all</a>
        </div>
        <div class="mt-5 overflow-x-auto">
            <table class="w-full min-w-[520px] text-left text-sm">
                <thead class="border-b border-[#edf1eb] text-[10px] uppercase tracking-wider text-[#a0aaa1]">
                    <tr>
                        <th class="pb-3 font-semibold">Job position</th>
                        <th class="pb-3 font-semibold">Company</th>
                        <th class="pb-3 font-semibold">Pelamar</th>
                        <th class="pb-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentJobs ?? [] as $job)
                    <tr class="border-b border-[#f0f3ef] last:border-0">
                        <td class="py-4 font-semibold">{{ $job->title }}</td>
                        <td class="py-4 text-[#7d897f]">{{ $job->company->name }}</td>
                        <td class="py-4 text-[#667469]">{{ $job->applications_count }}</td>
                        <td class="py-4">
                            <span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $job->status === 'published' ? 'bg-[#edf8d6] text-[#6c972f]' : 'bg-[#fff3d9] text-[#b07a22]' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-8 text-center text-sm text-[#89958b]">Belum ada data lowongan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- System Health --}}
    <section class="rounded-2xl bg-[#1f3026] p-5 text-white lg:p-6">
        <div class="flex items-center gap-2 text-xs font-bold text-[#b7f34a]">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            SYSTEM HEALTH
        </div>
        <h3 class="mt-4 text-xl font-semibold tracking-[-0.03em]">Everything is running smoothly.</h3>
        <p class="mt-2 text-sm leading-6 text-[#adbbad]">Platform memproses {{ number_format($stats['ai_recommendations'] ?? 3842) }} rekomendasi AI bulan ini.</p>
        <div class="mt-7 space-y-4">
            @foreach([['Matching engine','99.98%'],['Career Agent','99.9%'],['Data pipeline','100%']] as [$label, $value])
            <div>
                <div class="flex justify-between text-xs">
                    <span class="text-[#bdcabe]">{{ $label }}</span>
                    <span class="font-bold text-[#b7f34a]">{{ $value }}</span>
                </div>
                <div class="mt-2 h-1.5 rounded-full bg-white/10">
                    <div class="h-full rounded-full bg-[#b7f34a]" style="width: {{ $value }}"></div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
