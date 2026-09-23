@extends('layouts.app')
@section('title', 'Detail Pelamar — NineteenJobs')
@section('page-title', 'Detail Pelamar')
@section('content')
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <a href="{{ route('employer.applications.index') }}" class="text-xs font-bold text-[#6b9c2b] hover:underline">←
                Kembali ke daftar pelamar</a>
            <h2 class="mt-3 text-2xl font-semibold tracking-[-0.04em]">{{ $application->user->name }}</h2>
            <p class="mt-1 text-sm text-[#89958b]">Melamar untuk {{ $application->jobListing->title }}</p>
        </div>
        <span
            class="rounded-full px-3 py-1.5 text-xs font-bold {{ match ($application->status_color) {
                'green' => 'bg-[#edf8d6] text-[#6c972f]',
                'yellow' => 'bg-[#fff3d9] text-[#b07a22]',
                'red' => 'bg-[#ffeded] text-[#c65d5d]',
                default => 'bg-[#f0f3ef] text-[#718074]',
            } }}">{{ $application->status_label }}</span>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_.8fr]">
        <div class="space-y-6">
            <section class="rounded-2xl border border-[#e1e9df] bg-white p-6">
                <h3 class="font-semibold">Profil kandidat</h3>
                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs text-[#89958b]">Email</p>
                        <p class="mt-1 text-sm font-medium">{{ $application->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#89958b]">Telepon</p>
                        <p class="mt-1 text-sm font-medium">{{ $application->user->phone ?: 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#89958b]">Headline</p>
                        <p class="mt-1 text-sm font-medium">
                            {{ $application->user->candidateProfile?->headline ?: 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#89958b]">Lokasi</p>
                        <p class="mt-1 text-sm font-medium">
                            {{ $application->user->candidateProfile?->location ?: 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#89958b]">Pengalaman</p>
                        <p class="mt-1 text-sm font-medium">
                            {{ $application->user->candidateProfile?->experience_years ?? 0 }} tahun</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#89958b]">Keahlian</p>
                        <p class="mt-1 text-sm font-medium">
                            {{ implode(', ', $application->user->candidateProfile?->skills ?? []) ?: 'Belum diisi' }}</p>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-[#e1e9df] bg-white p-6">
                <h3 class="font-semibold">Surat lamaran</h3>
                <p class="mt-4 whitespace-pre-line text-sm leading-6 text-[#556257]">
                    {{ $application->cover_letter ?: 'Pelamar tidak menambahkan surat lamaran.' }}</p>
            </section>
        </div>

        <div class="space-y-6">
            <section class="rounded-2xl border border-[#e1e9df] bg-white p-6">
                <h3 class="font-semibold">CV kandidat</h3>
                <p class="mt-2 text-sm text-[#89958b]">CV yang digunakan saat kandidat melamar.</p>
                @if ($application->resume_path || $application->user->candidateProfile?->resume_path)
                    <a href="{{ route('employer.applications.resume', $application) }}" target="_blank"
                        class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#b7f34a] px-4 py-2.5 text-sm font-bold text-[#182516] hover:bg-[#a5e839]">Buka
                        CV</a>
                @else
                    <p class="mt-4 rounded-xl bg-[#f8faf5] p-3 text-sm text-[#89958b]">Kandidat belum mengunggah CV.</p>
                @endif
            </section>

            <section class="rounded-2xl border border-[#e1e9df] bg-white p-6">
                <h3 class="font-semibold">Perbarui keputusan</h3>
                <form method="POST" action="{{ route('employer.applications.status', $application) }}"
                    class="mt-5 space-y-4">
                    @csrf @method('PATCH')
                    <div>
                        <label for="status" class="mb-1.5 block text-sm font-semibold">Status</label>
                        <select id="status" name="status"
                            class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm"
                            onchange="document.getElementById('interview-fields').hidden = this.value !== 'interview'">
                            @foreach (['pending' => 'Menunggu', 'review' => 'Ditinjau', 'interview' => 'Panggilan / Interview', 'offered' => 'Diterima', 'rejected' => 'Ditolak'] as $value => $label)
                                <option value="{{ $value }}" @selected($application->status === $value)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="interview-fields" class="space-y-4 rounded-xl bg-[#f8faf5] p-4"
                        @if ($application->status !== 'interview') hidden @endif>
                        <div>
                            <label for="interview_at" class="mb-1.5 block text-sm font-semibold">Waktu interview</label>
                            <input id="interview_at" name="interview_at" type="datetime-local"
                                value="{{ old('interview_at', $application->interview_at?->format('Y-m-d\\TH:i')) }}"
                                class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm">
                        </div>
                        <div>
                            <label for="interview_location" class="mb-1.5 block text-sm font-semibold">Lokasi / link
                                meeting</label>
                            <input id="interview_location" name="interview_location" type="text"
                                value="{{ old('interview_location', $application->interview_location) }}"
                                placeholder="Google Meet atau alamat kantor"
                                class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="employer_notes" class="mb-1.5 block text-sm font-semibold">Pesan untuk pelamar</label>
                        <textarea id="employer_notes" name="employer_notes" rows="4"
                            placeholder="Tulis informasi atau langkah berikutnya..."
                            class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-2.5 text-sm">{{ old('employer_notes', $application->employer_notes) }}</textarea>
                    </div>
                    <button type="submit"
                        class="w-full rounded-xl bg-[#b7f34a] px-4 py-2.5 text-sm font-bold text-[#182516] hover:bg-[#a5e839]">Simpan
                        keputusan</button>
                </form>
            </section>
        </div>
    </div>
@endsection
