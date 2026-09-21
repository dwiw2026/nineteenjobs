@extends('layouts.app')
@section('title', 'Profil Perusahaan — NineteenJobs')
@section('page-title', 'Profil Perusahaan')
@section('content')
<div class="mx-auto max-w-2xl space-y-6">

    @if(session('success'))
    <div class="rounded-xl bg-[#edfbd5] border border-[#b7f34a] px-4 py-3 text-sm text-[#3e7c0f]">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Company header --}}
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-6">
        <div class="flex items-center gap-4">
            <div class="grid size-14 shrink-0 place-items-center rounded-2xl bg-[#eaf5d4] text-2xl font-bold text-[#5f8a25]">
                {{ strtoupper(substr($company->name, 0, 1)) }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-semibold">{{ $company->name }}</h2>
                    @if($company->verified_at)
                    <span class="rounded-full bg-[#edfbd5] px-2 py-0.5 text-[10px] font-bold text-[#3e7c0f]">✓ Terverifikasi</span>
                    @endif
                </div>
                <p class="text-sm text-[#7b877d]">{{ $company->industry }} · {{ $company->location }}</p>
            </div>
        </div>
    </div>

    {{-- Edit form --}}
    <form method="POST" action="{{ route('employer.company.update', $company) }}" enctype="multipart/form-data" class="rounded-2xl border border-[#e1e9df] bg-white p-6 space-y-5">
        @csrf @method('PATCH')

        <h3 class="text-base font-semibold text-[#1f2d1f]">Informasi Perusahaan</h3>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Nama perusahaan *</label>
                <input id="name" name="name" type="text" value="{{ old('name', $company->name) }}" required
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="tagline" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Tagline</label>
                <input id="tagline" name="tagline" type="text" value="{{ old('tagline', $company->tagline) }}"
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                    placeholder="e.g. Inovasi untuk Indonesia">
            </div>
            <div>
                <label for="industry" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Industri</label>
                <input id="industry" name="industry" type="text" value="{{ old('industry', $company->industry) }}"
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                    placeholder="Teknologi, E-commerce, dsb">
            </div>
            <div>
                <label for="size" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Ukuran perusahaan</label>
                <select id="size" name="size" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none">
                    @foreach(['startup' => 'Startup', 'small' => 'Kecil (< 50)', 'medium' => 'Menengah (50–200)', 'large' => 'Besar (> 200)', 'enterprise' => 'Enterprise'] as $val => $label)
                    <option value="{{ $val }}" {{ old('size', $company->size) === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="location" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Lokasi</label>
                <input id="location" name="location" type="text" value="{{ old('location', $company->location) }}"
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                    placeholder="Jakarta">
            </div>
            <div>
                <label for="website" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Website</label>
                <input id="website" name="website" type="url" value="{{ old('website', $company->website) }}"
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                    placeholder="https://perusahaan.id">
                @error('website')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Deskripsi perusahaan</label>
            <textarea id="description" name="description" rows="4"
                class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                placeholder="Ceritakan tentang perusahaan kamu...">{{ old('description', $company->description) }}</textarea>
        </div>

        <div>
            <label for="logo" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Logo perusahaan <span class="font-normal text-[#9ba89c]">(opsional, maks 2MB)</span></label>
            <input id="logo" name="logo" type="file" accept="image/*"
                class="w-full text-sm text-[#7b877d] file:mr-4 file:rounded-xl file:border-0 file:bg-[#f4fbe6] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#5f8a25] hover:file:bg-[#e9f9cc]">
            @error('logo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('dashboard') }}" class="rounded-xl border border-[#dce6d9] bg-white px-5 py-2.5 text-sm font-semibold text-[#627064] hover:bg-[#f5f8f2] transition">Batal</a>
            <button type="submit" class="rounded-xl bg-[#b7f34a] px-5 py-2.5 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">Simpan Perubahan</button>
        </div>
    </form>

    {{-- Danger zone --}}
    <div class="rounded-2xl border border-red-200 bg-white p-6">
        <h3 class="text-sm font-semibold text-red-700">Zona Berbahaya</h3>
        <p class="mt-1 text-xs text-[#9ba89c]">Menghapus perusahaan akan menghapus semua lowongan dan data terkait secara permanen.</p>
        <form method="POST" action="{{ route('employer.company.destroy', $company) }}" class="mt-4"
            onsubmit="return confirm('Yakin ingin menghapus perusahaan ini? Semua lowongan akan ikut terhapus.')">
            @csrf @method('DELETE')
            <button type="submit" class="rounded-xl bg-red-50 border border-red-200 px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-100 transition">
                Hapus Perusahaan
            </button>
        </form>
    </div>
</div>
@endsection
