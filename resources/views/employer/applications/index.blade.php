@extends('layouts.app')
@section('title', 'Pelamar — NineteenJobs')
@section('page-title', 'Pelamar')
@section('content')
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-[.16em] text-[#82b52f]">{{ $company->name }}</p>
        <h2 class="mt-1 text-2xl font-semibold tracking-[-0.04em]">Daftar pelamar</h2>
        <p class="mt-1 text-sm text-[#89958b]">Kelola kandidat yang melamar ke lowongan perusahaanmu.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-[#e1e9df] bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead class="border-b border-[#edf1eb] bg-[#fbfcfa] text-[10px] uppercase tracking-wider text-[#a0aaa1]">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Pelamar</th>
                        <th class="px-5 py-4 font-semibold">Lowongan</th>
                        <th class="px-5 py-4 font-semibold">Tanggal melamar</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr class="border-b border-[#f0f3ef] last:border-0">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="grid size-9 place-items-center rounded-full bg-[#eaf8ce] text-xs font-bold text-[#5f8a25]">
                                        {{ strtoupper(substr($application->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $application->user->name }}</p>
                                        <p class="text-xs text-[#89958b]">{{ $application->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 font-medium text-[#536356]">{{ $application->jobListing->title }}</td>
                            <td class="px-5 py-4 text-[#7e897f]">
                                {{ ($application->applied_at ?? $application->created_at)->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-4">
                                <span
                                    class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ match ($application->status_color) {
                                        'green' => 'bg-[#edf8d6] text-[#6c972f]',
                                        'yellow' => 'bg-[#fff3d9] text-[#b07a22]',
                                        'red' => 'bg-[#ffeded] text-[#c65d5d]',
                                        default => 'bg-[#f0f3ef] text-[#718074]',
                                    } }}">{{ $application->status_label }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('employer.applications.show', $application) }}"
                                    class="rounded-lg bg-[#eaf8ce] px-3 py-2 text-xs font-bold text-[#5f8a25] hover:bg-[#d9f2b5]">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-sm text-[#89958b]">Belum ada pelamar untuk
                                lowongan perusahaanmu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($applications->hasPages())
            <div class="border-t border-[#edf1eb] px-5 py-4">{{ $applications->links() }}</div>
        @endif
    </div>
@endsection
