@extends('layouts.app')
@section('title', 'Edit Lowongan — NineteenJobs')
@section('page-title', 'Edit Lowongan')
@section('content')
<form method="POST" action="{{ route('employer.jobs.update', $job) }}" class="mx-auto max-w-2xl space-y-6">
    @csrf @method('PUT')
    <div class="rounded-2xl border border-[#e1e9df] bg-white p-6 space-y-5">
        <div>
            <label for="title" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Judul posisi</label>
            <input id="title" name="title" type="text" value="{{ old('title', $job->title) }}" required class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
        </div>
        <div>
            <label for="description" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Deskripsi</label>
            <textarea id="description" name="description" rows="6" required class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">{{ old('description', $job->description) }}</textarea>
        </div>
        <div>
            <label for="status" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Status</label>
            <select id="status" name="status" class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none">
                @foreach(['draft','published','closed'] as $s)
                <option value="{{ $s }}" {{ $job->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="flex justify-end gap-3">
        <a href="{{ route('employer.jobs.index') }}" class="rounded-xl border border-[#dce6d9] bg-white px-6 py-3 text-sm font-semibold text-[#627064]">Batal</a>
        <button type="submit" class="rounded-xl bg-[#b7f34a] px-6 py-3 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">Simpan</button>
    </div>
</form>
@endsection
