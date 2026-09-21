@extends('layouts.guest')
@section('title', 'Masuk — NineteenJobs')
@section('content')
<div class="flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center px-8 py-12 sm:px-16 lg:max-w-lg">
        <a href="/" class="flex items-center gap-2.5 mb-10">
            <div class="grid size-8 place-items-center rounded-xl bg-[#b7f34a] text-[#12210d]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
            </div>
            <span class="text-lg font-bold tracking-[-0.04em]">nineteen<span class="text-[#82b72d]">jobs</span></span>
        </a>

        <h1 class="text-3xl font-semibold tracking-[-0.04em]">Selamat datang kembali</h1>
        <p class="mt-2 text-sm text-[#647066]">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-[#6b9c2b] hover:underline">Daftar gratis</a></p>

        @if (session('status'))
            <div class="mt-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold text-[#2d3d30] mb-1.5">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30 {{ $errors->has('email') ? 'border-red-400' : '' }}"
                    placeholder="email@kamu.com">
                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="text-sm font-semibold text-[#2d3d30]">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-[#6b9c2b] hover:underline">Lupa password?</a>
                    @endif
                </div>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-xl border border-[#dce7d6] bg-white px-4 py-3 text-sm focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                    placeholder="Password kamu">
                @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <label class="flex items-center gap-2 text-sm text-[#556257]">
                <input type="checkbox" name="remember" class="rounded border-[#dce7d6]">
                Ingat saya
            </label>
            <button type="submit" class="w-full rounded-xl bg-[#b7f34a] py-3.5 text-sm font-bold text-[#182516] transition hover:bg-[#a5e839]">
                Masuk →
            </button>
        </form>
    </div>
    <div class="hidden lg:flex flex-1 items-center justify-center bg-[#f4fbe6] p-12">
        <div class="max-w-md">
            <div class="rounded-2xl bg-white p-6 shadow-xl border border-[#dce7d6]">
                <div class="flex items-center gap-3 mb-4">
                    <div class="grid size-10 place-items-center rounded-full bg-[#b7f34a]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Career Agent</p>
                        <p class="text-xs text-[#82907f]">Online · siap membantu</p>
                    </div>
                </div>
                <div class="rounded-2xl bg-[#f4fbe6] p-3 text-sm text-[#566354] leading-6">Selamat datang kembali! Saya sudah menemukan 3 lowongan baru yang cocok untuk kamu hari ini.</div>
            </div>
        </div>
    </div>
</div>
@endsection
