@extends('layouts.app')

@section('title', $jobListing->title)
@section('page-title', $jobListing->title)

@section('content')
<div class="mb-6">
    <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#78a52e] hover:underline">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Cari Lowongan
    </a>
</div>

<div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
    <div class="space-y-6">
        <div class="rounded-2xl border border-[#e2eae0] bg-white p-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex gap-4">
                    <div class="grid size-14 place-items-center rounded-2xl bg-[#eff6e8] text-2xl font-bold text-[#78a931]">
                        {{ substr($jobListing->company->name ?? 'C', 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">{{ $jobListing->title }}</h1>
                        <p class="mt-1 text-sm text-[#7b877e]">{{ $jobListing->company->name ?? 'Perusahaan' }}</p>
                    </div>
                </div>
                <span class="rounded-full bg-[#f0f5ec] px-3 py-1 text-xs font-semibold text-[#546b57]">
                    {{ $jobListing->work_type_label }}
                </span>
            </div>

            <div class="mt-6 flex flex-wrap gap-4 border-t border-b border-[#f0f3ef] py-4 text-xs text-[#7e897f]">
                <div>
                    <span class="block text-[#a0aaa1]">Lokasi</span>
                    <span class="font-semibold text-[#19251d]">{{ $jobListing->location ?? 'Indonesia' }}</span>
                </div>
                <div class="border-l border-[#e8ede6] pl-4">
                    <span class="block text-[#a0aaa1]">Gaji</span>
                    <span class="font-semibold text-[#536356]">{{ $jobListing->salary_range ?? 'Negotiable' }}</span>
                </div>
                <div class="border-l border-[#e8ede6] pl-4">
                    <span class="block text-[#a0aaa1]">Pengalaman</span>
                    <span class="font-semibold text-[#19251d]">{{ $jobListing->experience_level ?? 'Semua level' }}</span>
                </div>
                <div class="border-l border-[#e8ede6] pl-4">
                    <span class="block text-[#a0aaa1]">Tipe Pekerjaan</span>
                    <span class="font-semibold text-[#19251d]">{{ ucfirst($jobListing->employment_type ?? 'Full-time') }}</span>
                </div>
            </div>

            @if(!empty($jobListing->skills_required))
            <div class="mt-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#89958b] mb-2">Keahlian yang Dibutuhkan</h3>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($jobListing->skills_required as $skill)
                    <span class="rounded-md bg-[#eff6e8] px-2.5 py-1 text-xs font-medium text-[#5f8a25]">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mt-6">
                <h3 class="text-base font-bold text-[#19251d] mb-2">Deskripsi Pekerjaan</h3>
                <div class="prose prose-sm max-w-none text-[#566558] leading-relaxed whitespace-pre-line">
                    {{ $jobListing->description }}
                </div>
            </div>

            @if($jobListing->requirements)
            <div class="mt-6">
                <h3 class="text-base font-bold text-[#19251d] mb-2">Persyaratan</h3>
                <div class="prose prose-sm max-w-none text-[#566558] leading-relaxed whitespace-pre-line">
                    {{ $jobListing->requirements }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-[#e2eae0] bg-white p-6">
            <h3 class="font-semibold text-[#19251d] mb-3">Tentang Perusahaan</h3>
            <p class="text-sm font-medium">{{ $jobListing->company->name ?? 'Perusahaan' }}</p>
            @if($jobListing->company?->description)
            <p class="mt-2 text-xs text-[#7b877e] leading-relaxed">{{ $jobListing->company->description }}</p>
            @endif
            @if($jobListing->company?->website)
            <a href="{{ $jobListing->company->website }}" target="_blank" class="mt-3 inline-block text-xs font-semibold text-[#78a52e] hover:underline">Kunjungi Website Perusahaan →</a>
            @endif
        </div>

        @if(isset($similar) && $similar->isNotEmpty())
        <div class="rounded-2xl border border-[#e2eae0] bg-white p-6">
            <h3 class="font-semibold text-[#19251d] mb-4">Lowongan Lainnya</h3>
            <div class="space-y-3">
                @foreach($similar as $simJob)
                <a href="{{ route('jobs.show', $simJob) }}" class="block rounded-xl border border-[#f0f3ef] p-3 hover:bg-[#f9fbf8] transition">
                    <p class="text-xs font-semibold text-[#19251d]">{{ $simJob->title }}</p>
                    <p class="mt-1 text-[11px] text-[#7e897f]">{{ $simJob->location }} · {{ $simJob->work_type_label }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
