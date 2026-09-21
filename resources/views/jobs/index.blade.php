@extends('layouts.app')
@section('title', 'Lowongan — NineteenJobs')
@section('page-title', 'Cari Lowongan')
@section('content')
<div class="mb-6">
    <form method="GET" action="{{ route('jobs.index') }}" class="flex gap-3">
        <input name="q" value="{{ request('q') }}" placeholder="Cari posisi, skill, atau perusahaan..." class="flex-1 rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
        <select name="work_type" class="rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm">
            <option value="">Semua tipe</option>
            <option value="remote" {{ request('work_type') === 'remote' ? 'selected' : '' }}>Remote</option>
            <option value="hybrid" {{ request('work_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
            <option value="onsite" {{ request('work_type') === 'onsite' ? 'selected' : '' }}>On-site</option>
        </select>
        <button type="submit" class="rounded-xl bg-[#b7f34a] px-6 py-3 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">Cari</button>
    </form>
</div>
<div class="grid gap-4 lg:grid-cols-3">
    @forelse($jobs as $job)
    <a href="{{ route('jobs.show', $job) }}" class="block rounded-2xl border border-[#e2eae0] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg">
        <div class="flex items-start justify-between">
            <div class="flex gap-3">
                <div class="grid size-11 place-items-center rounded-xl bg-[#eff6e8] text-lg font-bold text-[#78a931]">{{ substr($job->company->name ?? 'C', 0, 1) }}</div>
                <div>
                    <h3 class="font-semibold">{{ $job->title }}</h3>
                    <p class="mt-0.5 text-xs text-[#7b877e]">{{ $job->company->name ?? '' }}</p>
                </div>
            </div>
        </div>
        <div class="mt-3 flex flex-wrap gap-1.5">
            @foreach(array_slice($job->skills_required ?? [], 0, 3) as $skill)
            <span class="rounded-md bg-[#f2f5ef] px-2 py-1 text-[11px] text-[#637064]">{{ $skill }}</span>
            @endforeach
        </div>
        <div class="mt-4 flex items-center justify-between text-xs text-[#7e897f]">
            <span>{{ $job->location }} · {{ $job->work_type_label }}</span>
            <span class="font-semibold text-[#536356]">{{ $job->salary_range ?? 'Negotiable' }}</span>
        </div>
    </a>
    @empty
    <div class="col-span-3 text-center py-12 text-sm text-[#89958b]">Tidak ada lowongan yang sesuai.</div>
    @endforelse
</div>
<div class="mt-8">{{ $jobs->links() }}</div>
@endsection
