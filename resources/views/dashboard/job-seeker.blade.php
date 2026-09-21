@extends('layouts.app')

@section('title', 'Dashboard Saya — NineteenJobs')
@section('page-title', 'Halo, ' . auth()->user()->name . '!')

@section('content')
{{-- Profile completeness banner --}}
@php $profile = auth()->user()->candidateProfile; @endphp
@if (!$profile || ($profile->profile_completeness ?? 0) < 80)
<div class="mb-6 rounded-2xl border border-[#dce7d6] bg-[#f4fbe6] p-4 flex items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <div class="grid size-10 place-items-center rounded-xl bg-[#b7f34a] text-[#12210d] shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
        </div>
        <div>
            <p class="text-sm font-bold text-[#3d6020]">Profil kamu {{ $profile?->profile_completeness ?? 0 }}% lengkap</p>
            <p class="text-xs text-[#6b8b4a]">Lengkapi profil untuk mendapat match yang lebih akurat dari Career Agent.</p>
        </div>
    </div>
    <a href="{{ route('profile.edit') }}" class="shrink-0 rounded-xl bg-[#b7f34a] px-4 py-2 text-xs font-bold text-[#182516] hover:bg-[#a5e839] transition">Lengkapi →</a>
</div>
@endif

{{-- Top matches --}}
<div class="mb-8">
    <div class="mb-4 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.16em] text-[#82b52f]">AI Matching</p>
            <h2 class="mt-1 text-2xl font-semibold tracking-[-0.04em]">Lowongan terbaik untukmu</h2>
        </div>
        <a href="{{ route('matches.index') }}" class="text-xs font-bold text-[#6b9c2b]">Lihat semua →</a>
    </div>
    <div class="grid gap-4 lg:grid-cols-3">
        @forelse($topMatches ?? [] as $match)
        <div class="rounded-2xl border border-[#e2eae0] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex gap-3">
                    <div class="grid size-11 place-items-center rounded-xl bg-[#eff6e8] text-lg font-bold text-[#78a931]">
                        {{ substr($match->jobListing->company->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-sm">{{ $match->jobListing->title }}</p>
                        <p class="mt-0.5 text-xs text-[#7a867a]">{{ $match->jobListing->company->name }}</p>
                    </div>
                </div>
                <span class="rounded-full bg-[#e8f9bd] px-2.5 py-1 text-xs font-bold text-[#537721]">{{ $match->score }}%</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-1.5">
                @foreach(array_slice($match->skill_overlap ?? [], 0, 3) as $skill)
                <span class="rounded-md bg-[#f2f5ef] px-2 py-1 text-[11px] text-[#637064]">{{ $skill }}</span>
                @endforeach
            </div>
            <div class="mt-4 flex items-center justify-between text-xs text-[#7e897f]">
                <span>{{ $match->jobListing->location }} · {{ $match->jobListing->work_type_label }}</span>
                <span class="font-semibold text-[#536356]">{{ $match->jobListing->salary_range ?? 'Negotiable' }}</span>
            </div>
            @if(!empty($match->missing_skills))
            <div class="mt-3 rounded-xl bg-[#fef9ec] border border-[#f5e4a0] p-3 text-xs text-[#7a6620]">
                <span class="font-semibold">Skill gap:</span> {{ implode(', ', array_slice($match->missing_skills, 0, 2)) }}
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-3 rounded-2xl border border-[#e2eae0] bg-white p-10 text-center">
            <p class="text-sm text-[#89958b]">Belum ada match. Lengkapi profil untuk mulai mendapatkan rekomendasi.</p>
            <a href="{{ route('profile.edit') }}" class="mt-4 inline-block rounded-xl bg-[#b7f34a] px-5 py-2.5 text-sm font-bold text-[#182516]">Lengkapi profil</a>
        </div>
        @endforelse
    </div>
</div>

{{-- Quick stats --}}
<div class="grid gap-4 sm:grid-cols-3">
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-5">
        <div class="grid size-9 place-items-center rounded-xl bg-[#eff8dc] text-[#78a92f] mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <p class="text-2xl font-semibold tracking-[-0.05em]">{{ $applicationCount ?? 0 }}</p>
        <p class="mt-1 text-xs text-[#89958b]">Lamaran dikirim</p>
    </div>
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-5">
        <div class="grid size-9 place-items-center rounded-xl bg-[#eff8dc] text-[#78a92f] mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
        </div>
        <p class="text-2xl font-semibold tracking-[-0.05em]">{{ $matchCount ?? 0 }}</p>
        <p class="mt-1 text-xs text-[#89958b]">Match ditemukan</p>
    </div>
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-5">
        <div class="grid size-9 place-items-center rounded-xl bg-[#eff8dc] text-[#78a92f] mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        </div>
        <p class="text-2xl font-semibold tracking-[-0.05em]">{{ $roadmapCount ?? 0 }}</p>
        <p class="mt-1 text-xs text-[#89958b]">Roadmap aktif</p>
    </div>
</div>

{{-- Recent applications + Career Agent link --}}
<div class="mt-6 grid gap-6 xl:grid-cols-[1.45fr_1fr]">
    <section class="rounded-2xl border border-[#e1e9df] bg-white p-5 lg:p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold">Lamaran terbaru</h3>
            <a href="{{ route('applications.index') }}" class="text-xs font-bold text-[#78a52e]">Lihat semua</a>
        </div>
        @forelse($recentApplications ?? [] as $app)
        <div class="flex items-center justify-between py-3 border-b border-[#f0f3ef] last:border-0">
            <div>
                <p class="text-sm font-semibold">{{ $app->jobListing->title }}</p>
                <p class="text-xs text-[#89958b]">{{ $app->jobListing->company->name }} · {{ $app->applied_at->diffForHumans() }}</p>
            </div>
            <span class="rounded-full px-2.5 py-1 text-[10px] font-bold
                {{ match($app->status) { 'interview','offered' => 'bg-[#edf8d6] text-[#6c972f]', 'rejected','withdrawn' => 'bg-red-50 text-red-600', default => 'bg-[#fff3d9] text-[#b07a22]' } }}">
                {{ $app->status_label }}
            </span>
        </div>
        @empty
        <p class="text-sm text-[#89958b] text-center py-6">Belum ada lamaran. <a href="{{ route('jobs.index') }}" class="font-semibold text-[#6b9c2b]">Cari lowongan →</a></p>
        @endforelse
    </section>

    {{-- Telegram link card --}}
    @php $tg = auth()->user()->telegramChannel; @endphp
    <section class="rounded-2xl bg-[#1f3026] p-5 text-white lg:p-6">
        <div class="flex items-center gap-2 text-xs font-bold text-[#b7f34a] mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
            CAREER AGENT
        </div>
        @if($tg?->is_linked)
        <h3 class="text-lg font-semibold">Terhubung ke Telegram!</h3>
        <p class="mt-2 text-sm leading-6 text-[#adbbad]">Akun kamu sudah terhubung sebagai {{ $tg->display_name }}. Kamu bisa tanya Career Agent kapan saja.</p>
        <a href="https://t.me/{{ config('services.telegram.bot_username') }}" target="_blank" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#b7f34a] px-4 py-2.5 text-xs font-bold text-[#182516]">Buka Telegram →</a>
        @else
        <h3 class="text-lg font-semibold">Hubungkan ke Telegram</h3>
        <p class="mt-2 text-sm leading-6 text-[#adbbad]">Dapatkan akses Career Agent 24/7 langsung di Telegram kamu.</p>
        <form method="POST" action="{{ route('telegram.link') }}" class="mt-5">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#b7f34a] px-4 py-2.5 text-xs font-bold text-[#182516]">
                Generate link Telegram →
            </button>
        </form>
        @endif
    </section>
</div>
@endsection
