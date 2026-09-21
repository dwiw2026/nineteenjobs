@extends('layouts.app')
@section('title', 'Career Agent — NineteenJobs')
@section('page-title', 'Career Agent')
@section('content')
<div class="max-w-2xl mx-auto">
    @php $tg = auth()->user()?->telegramChannel; @endphp
    <div class="rounded-2xl bg-[#1f3026] p-6 sm:p-8 text-white shadow-sm">
        <div class="flex items-center gap-2 text-xs font-bold tracking-wider text-[#b7f34a] mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
            CAREER AGENT
        </div>

        @if($tg?->is_linked)
            <h2 class="text-2xl font-bold">Terhubung ke Telegram!</h2>
            <p class="mt-2 text-sm leading-6 text-[#adbbad]">
                Akun kamu sudah terhubung sebagai <span class="font-semibold text-white">{{ $tg->display_name }}</span>. Kamu bisa berinteraksi dan berkonsultasi karir dengan Career Agent kapan saja melalui Telegram.
            </p>
            <div class="mt-6">
                <a href="https://t.me/{{ config('services.telegram.bot_username', 'nineteenjobs_bot') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-[#b7f34a] px-5 py-3 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Buka Telegram Bot →
                </a>
            </div>
        @else
            <h2 class="text-2xl font-bold">Konsultasi dengan Career Agent</h2>
            <p class="mt-2 text-sm leading-6 text-[#adbbad]">
                Dapatkan rekomendasi lowongan, analisis skill gap, dan panduan roadmap karir langsung lewat Telegram secara interaktif 24/7.
            </p>
            <div class="mt-6">
                @if (Route::has('telegram.link'))
                <form method="POST" action="{{ route('telegram.link') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#b7f34a] px-5 py-3 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        Hubungkan Akun Telegram →
                    </button>
                </form>
                @else
                <a href="https://t.me/{{ config('services.telegram.bot_username', 'nineteenjobs_bot') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-[#b7f34a] px-5 py-3 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">
                    Buka Telegram Bot →
                </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
