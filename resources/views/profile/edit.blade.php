@extends('layouts.app')
@section('title', 'Profil Saya — NineteenJobs')
@section('page-title', 'Pengaturan Profil')
@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-6">
        <h3 class="text-lg font-semibold tracking-tight">Informasi Akun</h3>
        <p class="mt-1 text-sm text-[#7b877d]">Perbarui nama, email, dan detail akun Anda.</p>
        <div class="mt-6 max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    @if(auth()->user()->isJobSeeker())
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-6">
        <h3 class="text-lg font-semibold tracking-tight">Profil Kandidat</h3>
        <p class="mt-1 text-sm text-[#7b877d]">Data ini digunakan oleh Career Agent untuk mencari kecocokan terbaik.</p>
        <form method="post" action="{{ route('candidate.profile.update') }}" class="mt-6 space-y-5 max-w-xl">
            @csrf @method('patch')
            @php $profile = auth()->user()->candidateProfile; @endphp
            <div>
                <label for="headline" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Headline</label>
                <input id="headline" name="headline" type="text" value="{{ old('headline', $profile?->headline) }}" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30" placeholder="e.g. Frontend Developer">
            </div>
            <div>
                <label for="skills" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Skills (pisahkan dengan koma)</label>
                <input id="skills" name="skills" type="text" value="{{ old('skills', implode(', ', $profile?->skills ?? [])) }}" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30" placeholder="React, Laravel, CSS">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="experience_years" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Tahun Pengalaman</label>
                    <input id="experience_years" name="experience_years" type="number" min="0" value="{{ old('experience_years', $profile?->experience_years) }}" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
                </div>
                <div>
                    <label for="location" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Lokasi</label>
                    <input id="location" name="location" type="text" value="{{ old('location', $profile?->location) }}" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-xl bg-[#b7f34a] px-5 py-2 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">Simpan Profil</button>
            </div>
        </form>
    </div>
    @endif

    <div class="rounded-2xl border border-[#e1e9df] bg-white p-6">
        <h3 class="text-lg font-semibold tracking-tight">Ubah Password</h3>
        <div class="mt-6 max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</div>
@endsection
