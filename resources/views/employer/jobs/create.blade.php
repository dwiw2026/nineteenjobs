@extends('layouts.app')
@section('title', 'Buat Lowongan — NineteenJobs')
@section('page-title', 'Buat Lowongan Baru')
@section('content')
<form method="POST" action="{{ route('employer.jobs.store') }}" class="mx-auto max-w-2xl space-y-6">
    @csrf
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-6 space-y-5">
        <div>
            <label for="title" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Judul posisi *</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}" required class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30" placeholder="e.g. Frontend Developer">
            @error('title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="description" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Deskripsi pekerjaan *</label>
            <textarea id="description" name="description" rows="6" required class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30" placeholder="Jelaskan tanggung jawab utama...">{{ old('description') }}</textarea>
            @error('description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="requirements" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Persyaratan</label>
            <textarea id="requirements" name="requirements" rows="4" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">{{ old('requirements') }}</textarea>
        </div>
        <div>
            <label for="skills_required" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Skill yang dibutuhkan</label>
            <input id="skills_required" name="skills_required" type="text" value="{{ old('skills_required') }}" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30" placeholder="React, TypeScript, CSS (pisahkan dengan koma)">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="salary_min" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Gaji minimum (Rp)</label>
                <input id="salary_min" name="salary_min" type="number" value="{{ old('salary_min') }}" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30" placeholder="7000000">
            </div>
            <div>
                <label for="salary_max" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Gaji maksimum (Rp)</label>
                <input id="salary_max" name="salary_max" type="number" value="{{ old('salary_max') }}" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30" placeholder="10000000">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="work_type" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Tipe kerja *</label>
                <select id="work_type" name="work_type" required class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none">
                    <option value="onsite" {{ old('work_type') === 'onsite' ? 'selected' : '' }}>On-site</option>
                    <option value="hybrid" {{ old('work_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    <option value="remote" {{ old('work_type') === 'remote' ? 'selected' : '' }}>Remote</option>
                </select>
            </div>
            <div>
                <label for="employment_type" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Jenis pekerjaan *</label>
                <select id="employment_type" name="employment_type" required class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none">
                    <option value="full_time">Full-time</option>
                    <option value="part_time">Part-time</option>
                    <option value="contract">Kontrak</option>
                    <option value="internship">Magang</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="location" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Lokasi</label>
                <input id="location" name="location" type="text" value="{{ old('location') }}" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30" placeholder="Jakarta">
            </div>
            <div>
                <label for="experience_level" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Level pengalaman</label>
                <select id="experience_level" name="experience_level" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none">
                    <option value="">Pilih level</option>
                    <option value="junior">Junior</option>
                    <option value="mid">Mid-level</option>
                    <option value="senior">Senior</option>
                    <option value="lead">Lead</option>
                </select>
            </div>
        </div>
    </div>
    <div class="flex justify-end gap-3">
        <a href="{{ route('employer.jobs.index') }}" class="rounded-xl border border-[#dce6d9] bg-white px-6 py-3 text-sm font-semibold text-[#627064] hover:bg-[#f5f8f2] transition">Batal</a>
        <button type="submit" class="rounded-xl bg-[#b7f34a] px-6 py-3 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">Simpan sebagai draft</button>
    </div>
</form>
@endsection
