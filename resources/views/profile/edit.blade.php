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
        <form method="post" action="{{ route('candidate.profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5 max-w-xl">
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
            
            <div class="rounded-xl border border-[#dce7d6] bg-[#f8faf5] p-4">
                <label for="resume" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">CV / Resume (PDF, DOCX)</label>
                @if($profile?->resume_path)
                    <div class="mb-3 flex items-center gap-2 text-sm text-[#556257]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#78a92f]"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        <a href="{{ Storage::url($profile->resume_path) }}" target="_blank" class="font-medium text-[#5f8a25] hover:underline">Lihat CV tersimpan</a>
                    </div>
                @endif
                <input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx" class="block w-full text-sm text-[#7b877d] file:mr-4 file:rounded-lg file:border-0 file:bg-[#eaf8ce] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#5f8a25] hover:file:bg-[#d5f0a3]">
                <p class="mt-2 text-xs text-[#89958b]">Unggah file baru untuk mengganti CV yang lama. Maksimal 10 MB.</p>
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
