@extends('layouts.app')
@section('title', 'Beranda Perusahaan — NineteenJobs')
@section('content')
<div class="mx-auto max-w-5xl mt-10 px-4">
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ $company->logo_url }}"
                     alt="{{ $company->name }}"
                     class="h-14 w-14 rounded-xl object-cover">
                <div>
                    <h1 class="text-xl font-semibold">{{ $company->name }}</h1>
                    <p class="text-sm text-[#89958b]">{{ $company->tagline ?? 'Belum ada tagline' }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('employer.company.edit') }}"
                   class="inline-flex items-center rounded-xl bg-[#b7f34a] px-4 py-2 text-sm font-semibold text-[#12210d] hover:bg-[#a5e33a] transition">
                    Edit Profil
                </a>
                @if(auth()->user()->company && auth()->user()->company->id === $company->id)
                    <form action="{{ route('employer.company.destroy', $company) }}" method="POST" class="inline" onsubmit="return confirm('Hapus perusahaan ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-xl border border-red-300 bg-white px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2">
            <div class="rounded-xl bg-[#f7f9f5] p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#89958b]">Ukuran Perusahaan</p>
                <p class="mt-1 text-lg font-medium text-[#19251d]">{{ ucfirst($company->size ?? 'Belum ditentukan') }}</p>
            </div>
            <div class="rounded-xl bg-[#f7f9f5] p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#89958b]">Lokasi</p>
                <p class="mt-1 text-lg font-medium text-[#19251d]">{{ $company->location ?? 'Belum ditentukan' }}</p>
            </div>
            <div class="rounded-xl bg-[#f7f9f5] p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#89958b]">Industri</p>
                <p class="mt-1 text-lg font-medium text-[#19251d]">{{ $company->industry ?? 'Belum ditentukan' }}</p>
            </div>
            <div class="rounded-xl bg-[#f7f9f5] p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#89958b]">Website</p>
                <p class="mt-1">
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" rel="noopener"
                           class="text-[#5f8a25] underline hover:text-[#4a751f]">
                            {{ $company->website }}
                        </a>
                    @else
                        <span class="text-[#89958b]">Belum ada website</span>
                    @endif
                </p>
            </div>
        </div>

        @if($company->description)
            <div class="mt-6 rounded-xl border border-[#e1e9df] p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#89958b]">Tentang Kami</p>
                <p class="mt-2 text-[#19251d] whitespace-pre-line">{{ $company->description }}</p>
            </div>
        @endif

        @if($company->isVerified)
            <div class="mt-6 rounded-xl bg-[#eff8dc] p-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6 text-[#78a92f]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                <p class="mt-1 text-sm font-semibold text-[#5f8a25]">Perusahaan terverifikasi ✓</p>
            </div>
        @endif
    </div>
</div>
@endsection
