@extends('layouts.app')
@section('title', 'Dashboard Employer — NineteenJobs')
@section('page-title', 'Dashboard Employer')
@section('content')
@php $company = auth()->user()->company; @endphp

@if(!$company)
<div class="rounded-2xl border border-[#dce7d6] bg-[#f4fbe6] p-8 text-center">
    <div class="mx-auto grid size-14 place-items-center rounded-2xl bg-[#b7f34a] text-[#12210d] mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg>
    </div>
    <h2 class="text-xl font-semibold">Daftarkan Perusahaan Kamu</h2>
    <p class="mt-2 text-sm text-[#647066]">Mulai posting lowongan dan temukan kandidat terbaik.</p>
    <a href="{{ route('employer.company.create') }}" class="mt-5 inline-block rounded-full bg-[#b7f34a] px-6 py-3 text-sm font-bold text-[#182516]">Daftarkan perusahaan →</a>
</div>
@else

{{-- Stats --}}
<div class="mb-8">
    <div class="mb-4">
        <p class="text-xs font-bold uppercase tracking-[.16em] text-[#82b52f]">{{ $company->name }}</p>
        <h2 class="mt-1 text-2xl font-semibold tracking-[-0.04em]">Overview perusahaan</h2>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['label' => 'Lowongan aktif', 'value' => $stats['active_jobs'] ?? 0, 'icon' => 'briefcase'],
            ['label' => 'Total pelamar', 'value' => $stats['total_applicants'] ?? 0, 'icon' => 'users'],
            ['label' => 'Pelamar baru', 'value' => $stats['new_applicants'] ?? 0, 'icon' => 'user-plus'],
            ['label' => 'Tingkat respons', 'value' => ($stats['response_rate'] ?? 0) . '%', 'icon' => 'check-circle'],
        ] as $stat)
        <div class="rounded-2xl border border-[#e1e9df] bg-white p-5">
            <div class="grid size-9 place-items-center rounded-xl bg-[#eff8dc] text-[#78a92f] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    @if($stat['icon'] === 'briefcase') <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    @elseif($stat['icon'] === 'users') <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    @elseif($stat['icon'] === 'user-plus') <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>
                    @else <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    @endif
                </svg>
            </div>
            <p class="text-2xl font-semibold tracking-[-0.05em]">{{ $stat['value'] }}</p>
            <p class="mt-1 text-xs text-[#89958b]">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- Active jobs + Recent applicants --}}
<div class="grid gap-6 xl:grid-cols-[1.45fr_1fr]">
    <section class="rounded-2xl border border-[#e1e9df] bg-white p-5 lg:p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold">Lowongan aktif</h3>
            <a href="{{ route('employer.jobs.index') }}" class="text-xs font-bold text-[#78a52e]">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[480px] text-left text-sm">
                <thead class="border-b border-[#edf1eb] text-[10px] uppercase tracking-wider text-[#a0aaa1]">
                    <tr>
                        <th class="pb-3 font-semibold">Posisi</th>
                        <th class="pb-3 font-semibold">Pelamar</th>
                        <th class="pb-3 font-semibold">Status</th>
                        <th class="pb-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeJobs ?? [] as $job)
                    <tr class="border-b border-[#f0f3ef] last:border-0">
                        <td class="py-4 font-semibold">{{ $job->title }}</td>
                        <td class="py-4 text-[#667469]">{{ $job->applications_count }}</td>
                        <td class="py-4">
                            <span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $job->status === 'published' ? 'bg-[#edf8d6] text-[#6c972f]' : 'bg-[#fff3d9] text-[#b07a22]' }}">{{ ucfirst($job->status) }}</span>
                        </td>
                        <td class="py-4">
                            <a href="{{ route('employer.jobs.show', $job) }}" class="text-xs font-bold text-[#6b9c2b]">Lihat →</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-8 text-center text-sm text-[#89958b]">Belum ada lowongan. <a href="{{ route('employer.jobs.create') }}" class="font-bold text-[#6b9c2b]">Buat sekarang →</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-2xl border border-[#e1e9df] bg-white p-5 lg:p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold">Pelamar terbaru</h3>
            <a href="{{ route('employer.applications.index') }}" class="text-xs font-bold text-[#78a52e]">Semua →</a>
        </div>
        @forelse($recentApplicants ?? [] as $app)
        <div class="flex items-center justify-between py-3 border-b border-[#f0f3ef] last:border-0">
            <div class="flex items-center gap-3">
                <div class="grid size-9 place-items-center rounded-full bg-[#eaf8ce] text-[#5f8a25] text-xs font-bold">{{ substr($app->user->name, 0, 2) }}</div>
                <div>
                    <p class="text-sm font-semibold">{{ $app->user->name }}</p>
                    <p class="text-xs text-[#89958b]">{{ $app->jobListing->title }}</p>
                </div>
            </div>
            <span class="rounded-full px-2.5 py-1 text-[10px] font-bold bg-[#fff3d9] text-[#b07a22]">{{ $app->status_label }}</span>
        </div>
        @empty
        <p class="text-sm text-[#89958b] text-center py-6">Belum ada pelamar.</p>
        @endforelse
    </section>
</div>
@endif
@endsection
