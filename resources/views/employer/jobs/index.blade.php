@extends('layouts.app')
@section('title', 'Lowongan Saya — NineteenJobs')
@section('page-title', 'Lowongan Saya')
@section('content')
<div class="mb-6 flex items-center justify-between">
    <p class="text-sm text-[#89958b]">{{ $jobs->total() }} lowongan</p>
    <a href="{{ route('employer.jobs.create') }}" class="rounded-xl bg-[#b7f34a] px-5 py-2.5 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">+ Buat lowongan</a>
</div>
<div class="rounded-2xl border border-[#e1e9df] bg-white">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-[#edf1eb] text-[10px] uppercase tracking-wider text-[#a0aaa1]">
            <tr><th class="px-6 py-4 font-semibold">Posisi</th><th class="px-6 py-4 font-semibold">Pelamar</th><th class="px-6 py-4 font-semibold">Status</th><th class="px-6 py-4 font-semibold">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
            <tr class="border-b border-[#f0f3ef] last:border-0">
                <td class="px-6 py-4 font-semibold">{{ $job->title }}</td>
                <td class="px-6 py-4 text-[#667469]">{{ $job->applications_count }}</td>
                <td class="px-6 py-4"><span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $job->status === 'published' ? 'bg-[#edf8d6] text-[#6c972f]' : 'bg-[#fff3d9] text-[#b07a22]' }}">{{ ucfirst($job->status) }}</span></td>
                <td class="px-6 py-4"><a href="{{ route('employer.jobs.edit', $job) }}" class="text-xs font-bold text-[#6b9c2b]">Edit →</a></td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-12 text-center text-[#89958b]">Belum ada lowongan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $jobs->links() }}</div>
@endsection
