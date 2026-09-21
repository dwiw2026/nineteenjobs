@extends('layouts.guest')
@section('title', 'Daftar — NineteenJobs')
@section('content')
<div class="flex min-h-screen">
    {{-- Left: form --}}
    <div class="flex flex-1 flex-col justify-center px-8 py-12 sm:px-16 lg:max-w-lg">
        <a href="/" class="flex items-center gap-2.5 mb-10">
            <div class="grid size-8 place-items-center rounded-xl bg-[#b7f34a] text-[#12210d]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
            </div>
            <span class="text-lg font-bold tracking-[-0.04em]">nineteen<span class="text-[#82b72d]">jobs</span></span>
        </a>

        <h1 class="text-3xl font-semibold tracking-[-0.04em]">Buat akun baru</h1>
        <p class="mt-2 text-sm text-[#647066]">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-[#6b9c2b] hover:underline">Masuk di sini</a></p>

        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
            @csrf

            {{-- Role selection --}}
            <div>
                <label class="block text-sm font-semibold text-[#2d3d30] mb-3">Saya mendaftar sebagai</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="role-card cursor-pointer rounded-2xl border-2 p-4 transition
                        {{ old('role', 'job_seeker') === 'job_seeker' ? 'border-[#b7f34a] bg-[#f4fbe6]' : 'border-[#e2e9e0] bg-white hover:border-[#b7f34a]' }}">
                        <input type="radio" name="role" value="job_seeker" class="sr-only" {{ old('role', 'job_seeker') === 'job_seeker' ? 'checked' : '' }}>
                        <div class="grid size-8 place-items-center rounded-lg bg-[#edf8d9] text-[#79a82e] mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                        </div>
                        <p class="text-sm font-bold">Pencari Kerja</p>
                        <p class="text-xs text-[#7b877d] mt-1">Temukan lowongan yang cocok</p>
                    </label>
                    <label class="role-card cursor-pointer rounded-2xl border-2 p-4 transition
                        {{ old('role') === 'employer' ? 'border-[#b7f34a] bg-[#f4fbe6]' : 'border-[#e2e9e0] bg-white hover:border-[#b7f34a]' }}">
                        <input type="radio" name="role" value="employer" class="sr-only" {{ old('role') === 'employer' ? 'checked' : '' }}>
                        <div class="grid size-8 place-items-center rounded-lg bg-[#edf8d9] text-[#79a82e] mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg>
                        </div>
                        <p class="text-sm font-bold">Perusahaan</p>
                        <p class="text-xs text-[#7b877d] mt-1">Rekrut kandidat terbaik</p>
                    </label>
                </div>
                @error('role')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Nama lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30 {{ $errors->has('name') ? 'border-red-400' : '' }}"
                    placeholder="Nama kamu">
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30 {{ $errors->has('email') ? 'border-red-400' : '' }}"
                    placeholder="email@kamu.com">
                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30 {{ $errors->has('password') ? 'border-red-400' : '' }}"
                    placeholder="Minimal 8 karakter">
                @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Confirm password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Konfirmasi password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                    placeholder="Ulangi password">
            </div>

            <button type="submit" class="w-full rounded-xl bg-[#b7f34a] py-3.5 text-sm font-bold text-[#182516] transition hover:bg-[#a5e839]">
                Buat akun →
            </button>
        </form>
    </div>

    {{-- Right: decorative --}}
    <div class="hidden lg:flex flex-1 items-center justify-center bg-[#1f3026] p-12">
        <div class="max-w-md text-white">
            <div class="mb-8 flex items-center gap-2 text-xs font-bold text-[#b7f34a]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                AI-POWERED PLATFORM
            </div>
            <h2 class="text-4xl font-semibold leading-tight tracking-[-0.05em]">Karier yang bergerak dengan kamu.</h2>
            <p class="mt-4 text-sm leading-7 text-[#adbbad]">NineteenJobs menganalisis skill, pengalaman, dan potensimu untuk menemukan peluang yang benar-benar relevan.</p>
            <div class="mt-10 space-y-4">
                @foreach(['Match AI yang transparan dan dapat dijelaskan', 'Career Agent 24/7 via Telegram', 'Roadmap karier yang dipersonalisasi', 'Skill gap analysis otomatis'] as $feature)
                <div class="flex items-center gap-3 text-sm text-[#c8d8c4]">
                    <div class="grid size-5 place-items-center rounded-full bg-[#b7f34a]/20 text-[#b7f34a]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                    {{ $feature }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // Role card interactive selection
    document.querySelectorAll('.role-card').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.role-card').forEach(c => {
                c.classList.remove('border-[#b7f34a]', 'bg-[#f4fbe6]');
                c.classList.add('border-[#e2e9e0]', 'bg-white');
            });
            card.classList.add('border-[#b7f34a]', 'bg-[#f4fbe6]');
            card.classList.remove('border-[#e2e9e0]', 'bg-white');
            card.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>
@endsection
