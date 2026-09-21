@extends('layouts.app')
@section('title', 'Match Saya — NineteenJobs')
@section('page-title', 'Match Saya')
@section('content')

{{-- Header info --}}
<div class="mb-6 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-sm text-[#7b877d]">
            Ditemukan <span class="font-semibold text-[#2d3d30]">{{ $matches->total() }}</span> lowongan yang cocok berdasarkan profil kamu.
        </p>
    </div>
    <div class="flex items-center gap-2 text-xs text-[#89958b]">
        <span class="inline-block size-2 rounded-full bg-[#b7f34a]"></span> Skor dihitung real-time dari Profil Kandidat kamu
    </div>
</div>

{{-- Empty state --}}
@if($matches->isEmpty())
<div class="rounded-2xl border border-[#e1e9df] bg-white p-12 text-center">
    <div class="mx-auto mb-4 grid size-16 place-items-center rounded-2xl bg-[#eff8dc] text-[#78a92f]">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
    </div>
    <h3 class="text-lg font-semibold">Belum ada match ditemukan</h3>
    <p class="mt-2 text-sm text-[#89958b] max-w-sm mx-auto">Lengkapi dulu <a href="{{ route('profile.edit') }}" class="font-semibold text-[#6b9c2b] underline">profil kandidat</a> kamu — terutama bagian skill dan pengalaman, agar sistem dapat menghitung kecocokan.</p>
</div>

{{-- Match cards --}}
@else
<div class="space-y-4">
    @foreach($matches as $match)
    @php
        $job = $match->jobListing;
        $score = $match->score;
        $scoreColor = match(true) {
            $score >= 80 => ['bg' => '#edfbd5', 'text' => '#3e7c0f', 'bar' => '#b7f34a', 'label' => 'Sangat Cocok'],
            $score >= 60 => ['bg' => '#fffbe6', 'text' => '#8a6400', 'bar' => '#f9d84a', 'label' => 'Cukup Cocok'],
            default      => ['bg' => '#fef2f2', 'text' => '#9b1c1c', 'bar' => '#fca5a5', 'label' => 'Kurang Cocok'],
        };
    @endphp
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-6 transition hover:shadow-md">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            {{-- Left: job info --}}
            <div class="flex gap-4 flex-1">
                {{-- Company logo placeholder --}}
                <div class="grid size-12 shrink-0 place-items-center rounded-xl bg-[#eff6e8] text-lg font-bold text-[#78a931]">
                    {{ strtoupper(substr($job->company->name ?? 'C', 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-semibold text-[#1f2d1f]">{{ $job->title }}</h3>
                    <p class="text-sm text-[#7b877d]">{{ $job->company->name ?? '—' }} · {{ $job->location }}</p>
                    <div class="mt-2 flex flex-wrap gap-1.5">
                        @foreach(array_slice($job->skills_required ?? [], 0, 4) as $skill)
                        @php $isMatch = in_array(strtolower($skill), array_map('strtolower', $match->skill_overlap ?? [])); @endphp
                        <span class="rounded-md px-2 py-0.5 text-[11px] font-medium {{ $isMatch ? 'bg-[#e9fad2] text-[#3e7c0f]' : 'bg-[#f2f4ef] text-[#7b877d]' }}">
                            {{ $isMatch ? '✓ ' : '' }}{{ $skill }}
                        </span>
                        @endforeach
                        @if(count($job->skills_required ?? []) > 4)
                        <span class="rounded-md bg-[#f2f4ef] px-2 py-0.5 text-[11px] text-[#9ba89c]">+{{ count($job->skills_required) - 4 }} lagi</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: score --}}
            <div class="flex flex-col items-end gap-3 shrink-0 sm:min-w-[160px]">
                <div class="flex items-center gap-2">
                    <span class="rounded-full px-2.5 py-1 text-xs font-bold" style="background:{{ $scoreColor['bg'] }};color:{{ $scoreColor['text'] }}">
                        {{ $scoreColor['label'] }}
                    </span>
                    <span class="text-2xl font-bold tracking-tight text-[#1f2d1f]">{{ $score }}<span class="text-sm font-normal text-[#9ba89c]">%</span></span>
                </div>
                {{-- Progress bar --}}
                <div class="w-full max-w-[160px] overflow-hidden rounded-full bg-[#edf2eb] h-1.5">
                    <div class="h-full rounded-full transition-all" style="width:{{ $score }}%;background:{{ $scoreColor['bar'] }}"></div>
                </div>
                {{-- Score breakdown --}}
                @if($match->reasons && count($match->reasons))
                <div class="w-full max-w-[160px] space-y-1 text-[11px] text-[#89958b]">
                    @foreach($match->reasons as $reason)
                    <p>· {{ $reason }}</p>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Missing skills --}}
        @if(!empty($match->missing_skills))
        <div class="mt-4 rounded-xl bg-[#fefcf0] border border-[#f0e7b0] px-4 py-3">
            <p class="text-xs font-semibold text-[#8a7200] mb-1.5">Skill yang belum kamu miliki:</p>
            <div class="flex flex-wrap gap-1.5">
                @foreach($match->missing_skills as $skill)
                <span class="rounded-md bg-white border border-[#e8dc97] px-2 py-0.5 text-[11px] text-[#8a7200]">{{ $skill }}</span>
                @endforeach
            </div>
            <p class="mt-2 text-[11px] text-[#a08920]">💡 Tanya Career Agent kamu di Telegram untuk rekomendasi belajar skill ini.</p>
        </div>
        @endif

        {{-- Actions --}}
        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center gap-3 text-xs text-[#9ba89c]">
                <span>{{ $job->work_type_label }}</span>
                <span>·</span>
                <span>{{ $job->salary_range ?? 'Gaji negotiable' }}</span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('jobs.show', $job) }}" class="rounded-xl border border-[#dce6d9] bg-white px-4 py-2 text-xs font-semibold text-[#627064] hover:bg-[#f5f8f2] transition">Lihat detail</a>
                <a href="{{ route('jobs.show', $job) }}#apply" class="rounded-xl bg-[#b7f34a] px-4 py-2 text-xs font-bold text-[#182516] hover:bg-[#a5e839] transition">Lamar →</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-6">{{ $matches->links() }}</div>
@endif

{{-- Hermes CTA --}}
<div class="mt-8 rounded-2xl bg-[#1f3026] p-6 flex flex-col sm:flex-row items-start sm:items-center gap-5">
    <div class="grid size-12 shrink-0 place-items-center rounded-xl bg-[#b7f34a] text-[#12210d]">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-semibold text-white">Career Agent bisa bantu kamu lebih jauh</p>
        <p class="mt-1 text-xs text-[#adbbad] leading-5">Tanya langsung di Telegram: <em>"Kenapa skor saya 72%?"</em> atau <em>"Skill apa yang harus saya pelajari agar lolos Frontend Developer?"</em> — Agent mengakses data match kamu secara real-time.</p>
    </div>
    @php $tgLinked = auth()->user()->telegramChannel?->is_linked; @endphp
    @if($tgLinked)
    <a href="https://t.me/{{ config('services.telegram.bot_username') }}" target="_blank" class="shrink-0 rounded-xl bg-[#b7f34a] px-5 py-2.5 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">Buka Telegram →</a>
    @else
    <form method="POST" action="{{ route('telegram.link') }}" class="shrink-0">
        @csrf
        <button type="submit" class="rounded-xl bg-[#b7f34a] px-5 py-2.5 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">Hubungkan Telegram</button>
    </form>
    @endif
</div>

@endsection
