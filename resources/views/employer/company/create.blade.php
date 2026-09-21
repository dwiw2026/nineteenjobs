@extends('layouts.app')
@section('title', 'Daftarkan Perusahaan — NineteenJobs')
@section('page-title', 'Daftarkan Perusahaan')
@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-6 space-y-5">
        <div>
            <h3 class="text-base font-semibold">Informasi Perusahaan</h3>
            <p class="mt-1 text-sm text-[#7b877d]">Isi data perusahaan kamu untuk mulai memposting lowongan.</p>
        </div>

        <form method="POST" action="{{ route('employer.company.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Nama perusahaan *</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                        placeholder="PT. Perusahaan Kamu">
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="industry" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Industri</label>
                    <input id="industry" name="industry" type="text" value="{{ old('industry') }}"
                        class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                        placeholder="Teknologi, E-commerce, dsb">
                </div>
                <div>
                    <label for="size" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Ukuran</label>
                    <select id="size" name="size" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none">
                        @foreach(['startup' => 'Startup', 'small' => 'Kecil (< 50)', 'medium' => 'Menengah (50–200)', 'large' => 'Besar (> 200)', 'enterprise' => 'Enterprise'] as $val => $label)
                        <option value="{{ $val }}" {{ old('size') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="location" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Lokasi</label>
                    <input id="location" name="location" type="text" value="{{ old('location') }}"
                        class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                        placeholder="Jakarta">
                </div>
                <div>
                    <label for="website" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Website</label>
                    <input id="website" name="website" type="url" value="{{ old('website') }}"
                        class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                        placeholder="https://">
                    @error('website')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="tagline" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Tagline</label>
                    <input id="tagline" name="tagline" type="text" value="{{ old('tagline') }}"
                        class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                        placeholder="Inovasi untuk Indonesia">
                </div>
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                        placeholder="Ceritakan tentang perusahaan kamu...">{{ old('description') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label for="logo" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Logo <span class="font-normal text-[#9ba89c]">(opsional, maks 2MB)</span></label>
                    <input id="logo" name="logo" type="file" accept="image/*"
                        class="w-full text-sm text-[#7b877d] file:mr-4 file:rounded-xl file:border-0 file:bg-[#f4fbe6] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#5f8a25] hover:file:bg-[#e9f9cc]">
                    @error('logo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('dashboard') }}" class="rounded-xl border border-[#dce6d9] bg-white px-5 py-2.5 text-sm font-semibold text-[#627064] hover:bg-[#f5f8f2] transition">Batal</a>
                <button type="submit" class="rounded-xl bg-[#b7f34a] px-5 py-2.5 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">Daftarkan Perusahaan →</button>
            </div>
        </form>
    </div>
</div>
@endsection
