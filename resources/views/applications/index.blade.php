@extends('layouts.app')
@section('title', 'Lamaran Saya — NineteenJobs')
@section('page-title', 'Lamaran Saya')
@section('content')
<div class="rounded-2xl border border-[#e1e9df] bg-white p-6 lg:p-8">
    @if($applications->isEmpty())
        <div class="text-center py-12">
            <div class="mx-auto grid size-14 place-items-center rounded-2xl bg-[#eff8dc] text-[#78a92f] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <h2 class="text-xl font-semibold">Belum Ada Lamaran</h2>
            <p class="mt-2 text-sm text-[#89958b] max-w-md mx-auto">Anda belum melamar pekerjaan apa pun. Mulai cari lowongan yang cocok dan kirimkan lamaran Anda.</p>
            <a href="{{ route('jobs.index') }}" class="mt-6 inline-block rounded-xl bg-[#b7f34a] px-6 py-3 text-sm font-bold text-[#182516] hover:bg-[#a5e839] transition">
                Cari Lowongan
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#e1e9df] text-[#7b877d]">
                        <th class="pb-3 font-semibold">Posisi & Perusahaan</th>
                        <th class="pb-3 font-semibold">Tanggal Melamar</th>
                        <th class="pb-3 font-semibold">Status</th>
                        <th class="pb-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e1e9df]">
                    @foreach($applications as $app)
                    <tr>
                        <td class="py-4">
                            <a href="{{ route('jobs.show', $app->jobListing) }}" class="font-bold text-[#19251d] hover:text-[#5f8a25] transition">{{ $app->jobListing->title }}</a>
                            <div class="mt-1 text-xs text-[#7b877d]">{{ $app->jobListing->company->name ?? 'Perusahaan' }}</div>
                        </td>
                        <td class="py-4 text-[#556257]">
                            {{ $app->created_at->format('d M Y') }}
                        </td>
                        <td class="py-4">
                            @if($app->status === 'pending')
                                <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">Menunggu</span>
                            @elseif($app->status === 'review')
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">Direview</span>
                            @elseif($app->status === 'interview')
                                <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-800">Wawancara</span>
                            @elseif($app->status === 'rejected')
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">Ditolak</span>
                            @else
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-800">{{ ucfirst($app->status) }}</span>
                            @endif
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('jobs.show', $app->jobListing) }}" class="inline-block rounded-lg border border-[#e1e9df] px-3 py-1.5 text-xs font-semibold text-[#556257] hover:bg-[#f8faf5] transition">Lihat Lowongan</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
