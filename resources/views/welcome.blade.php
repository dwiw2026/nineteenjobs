@extends('layouts.guest')

@section('title', 'NineteenJobs — AI-powered Career Platform')

@section('content')
{{-- ── NAVBAR ──────────────────────────────────────────────────── --}}
<nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 lg:px-8">
    <a href="/" class="flex items-center gap-2.5">
        <div class="grid size-8 place-items-center rounded-xl bg-[#b7f34a] text-[#12210d]">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
        </div>
        <span class="text-lg font-bold tracking-[-0.04em]">nineteen<span class="text-[#82b72d]">jobs</span></span>
    </a>
    <div class="hidden items-center gap-8 text-sm font-medium text-[#556257] md:flex">
        <a href="#jobs" class="hover:text-[#1a3020] transition">Cari pekerjaan</a>
        <a href="#how" class="hover:text-[#1a3020] transition">Cara kerja</a>
        <a href="#agent" class="hover:text-[#1a3020] transition">Career Agent</a>
        <a href="#companies" class="hover:text-[#1a3020] transition">Untuk perusahaan</a>
    </div>
    <div class="flex items-center gap-3">
        @auth
            <a href="{{ route('dashboard') }}" class="rounded-full bg-[#16221b] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#324538]">Buka dashboard</a>
        @else
            <a href="{{ route('login') }}" class="hidden rounded-full px-4 py-2.5 text-sm font-semibold text-[#556257] sm:block hover:text-[#1a3020]">Masuk</a>
            <a href="{{ route('register') }}" class="rounded-full bg-[#16221b] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#324538]">Daftar gratis</a>
        @endauth
    </div>
</nav>

{{-- ── HERO ────────────────────────────────────────────────────── --}}
<section class="mx-auto grid max-w-7xl gap-12 px-5 pb-20 pt-12 lg:grid-cols-[1.04fr_.96fr] lg:items-center lg:px-8 lg:pb-28 lg:pt-20">
    <div>
        <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-[#dce7d6] bg-white px-3.5 py-2 text-xs font-semibold text-[#557243]">
            <span class="size-2 rounded-full bg-[#8ec83e]"></span>
            AI-powered career platform
        </div>
        <h1 class="max-w-2xl text-5xl font-semibold leading-[.99] tracking-[-0.065em] sm:text-7xl">
            Temukan karier yang <span class="text-[#84b931]">lebih cocok</span> untukmu.
        </h1>
        <p class="mt-7 max-w-xl text-lg leading-8 text-[#647066]">
            Bukan sekadar mencari berdasarkan kata kunci. NineteenJobs memahami skill, pengalaman, dan potensi kamu untuk menemukan peluang yang benar-benar relevan.
        </p>
        <div class="mt-9 flex flex-wrap gap-3">
            <a href="{{ route('register') }}" class="group flex items-center gap-3 rounded-full bg-[#b7f34a] px-6 py-3.5 text-sm font-bold text-[#182516] transition hover:bg-[#a5e839]">
                Cari pekerjaan
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition group-hover:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            <a href="#agent" class="flex items-center gap-2 rounded-full border border-[#d5e0d0] bg-white px-6 py-3.5 text-sm font-bold text-[#304032]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                Tanya Career Agent
            </a>
        </div>
        <div class="mt-12 flex items-center gap-8 border-t border-[#e1e9dd] pt-6">
            <div>
                <p class="text-2xl font-semibold tracking-tight">{{ number_format($stats['talents'] ?? 12800) }}<span class="text-[#86bb35]">+</span></p>
                <p class="mt-1 text-xs text-[#7d887f]">talent terdaftar</p>
            </div>
            <div>
                <p class="text-2xl font-semibold tracking-tight">{{ number_format($stats['jobs'] ?? 2400) }}<span class="text-[#86bb35]">+</span></p>
                <p class="mt-1 text-xs text-[#7d887f]">lowongan aktif</p>
            </div>
            <div>
                <p class="text-2xl font-semibold tracking-tight">91<span class="text-[#86bb35]">%</span></p>
                <p class="mt-1 text-xs text-[#7d887f]">match akurat</p>
            </div>
        </div>
    </div>

    {{-- Hero card --}}
    <div class="relative mx-auto w-full max-w-[520px]">
        <div class="absolute -right-5 top-8 size-40 rounded-full bg-[#dcf7a6] blur-2xl"></div>
        <div class="relative rounded-[2rem] border border-white bg-[#203028] p-4 shadow-2xl shadow-[#1a342322]">
            <div class="rounded-[1.5rem] bg-[#f4f8ef] p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-[#849184]">YOUR NEXT MOVE</p>
                        <h2 class="mt-1 text-xl font-semibold tracking-tight">Peluang terbaik minggu ini</h2>
                    </div>
                    <div class="grid size-10 place-items-center rounded-xl bg-[#b7f34a]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                    </div>
                </div>

                @if($featuredJob ?? false)
                <div class="mt-5 rounded-2xl bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="flex gap-3">
                            <div class="grid size-11 place-items-center rounded-xl bg-[#eff6e8] text-lg font-bold text-[#78a931]">{{ substr($featuredJob->company->name, 0, 1) }}</div>
                            <div>
                                <p class="font-semibold">{{ $featuredJob->title }}</p>
                                <p class="mt-1 text-xs text-[#7a867a]">{{ $featuredJob->company->name }} · {{ $featuredJob->location }}</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-[#e8f9bd] px-2.5 py-1 text-xs font-bold text-[#537721]">94% match</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach(array_slice($featuredJob->skills_required ?? [], 0, 3) as $skill)
                            <span class="rounded-md bg-[#f2f5ef] px-2 py-1 text-[11px] text-[#637064]">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="mt-5 rounded-2xl bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="flex gap-3">
                            <div class="grid size-11 place-items-center rounded-xl bg-[#eff6e8] text-lg font-bold text-[#78a931]">K</div>
                            <div>
                                <p class="font-semibold">Frontend Developer</p>
                                <p class="mt-1 text-xs text-[#7a867a]">KitaKarya Digital · Surabaya</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-[#e8f9bd] px-2.5 py-1 text-xs font-bold text-[#537721]">94% match</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="rounded-md bg-[#f2f5ef] px-2 py-1 text-[11px] text-[#637064]">React</span>
                        <span class="rounded-md bg-[#f2f5ef] px-2 py-1 text-[11px] text-[#637064]">JavaScript</span>
                        <span class="rounded-md bg-[#f2f5ef] px-2 py-1 text-[11px] text-[#637064]">Remote</span>
                    </div>
                </div>
                @endif

                <div class="mt-3 rounded-2xl border border-[#dbe8d3] bg-[#f4fbe6] p-4">
                    <div class="flex items-center gap-2 text-xs font-bold text-[#62852e]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                        INSIGHT DARI CAREER AGENT
                    </div>
                    <p class="mt-2 text-sm leading-6 text-[#4f604e]">Skill React-mu sudah kuat. Tingkatkan TypeScript untuk membuka 18 peluang baru.</p>
                </div>
                <div class="mt-5 flex items-center justify-between text-xs text-[#7a867a]">
                    <span>Profil kamu 85% lengkap</span>
                    <a href="{{ route('register') }}" class="font-semibold text-[#6b9c2b]">Lengkapi sekarang →</a>
                </div>
                <div class="mt-2 h-2 overflow-hidden rounded-full bg-[#e7ece3]">
                    <div class="h-full w-[85%] rounded-full bg-[#9fd541]"></div>
                </div>
            </div>
        </div>
        <div class="absolute -bottom-5 -left-6 flex items-center gap-3 rounded-2xl border border-[#e0eadb] bg-white p-3 shadow-xl">
            <div class="grid size-9 place-items-center rounded-full bg-[#ebf8cf] text-[#739e2c]">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold">Profil terverifikasi</p>
                <p class="text-[11px] text-[#8b958d]">Siap ditemukan recruiter</p>
            </div>
        </div>
    </div>
</section>

{{-- ── WHY NINETEENJOBS ────────────────────────────────────────── --}}
<section id="how" class="border-y border-[#e5ece1] bg-white px-5 py-16 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="max-w-xl">
            <p class="text-xs font-bold uppercase tracking-[.2em] text-[#84b931]">Why NineteenJobs</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-[-0.04em] sm:text-4xl">Karier yang bergerak<br>dengan kamu.</h2>
        </div>
        <div class="mt-10 grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-[#e6ede1] p-5">
                <div class="grid size-10 place-items-center rounded-xl bg-[#edf8d9] text-[#79a82e]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                </div>
                <h3 class="mt-5 font-semibold">AI Career Scan</h3>
                <p class="mt-2 text-sm leading-6 text-[#748075]">Ubah CV, pengalaman, dan potensimu menjadi profil karier yang mudah dipahami.</p>
            </div>
            <div class="rounded-2xl border border-[#e6ede1] p-5">
                <div class="grid size-10 place-items-center rounded-xl bg-[#edf8d9] text-[#79a82e]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
                <h3 class="mt-5 font-semibold">Match yang transparan</h3>
                <p class="mt-2 text-sm leading-6 text-[#748075]">Lihat alasan di balik setiap skor kecocokan—bukan angka yang muncul begitu saja.</p>
            </div>
            <div class="rounded-2xl border border-[#e6ede1] p-5">
                <div class="grid size-10 place-items-center rounded-xl bg-[#edf8d9] text-[#79a82e]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                </div>
                <h3 class="mt-5 font-semibold">Career Agent 24/7</h3>
                <p class="mt-2 text-sm leading-6 text-[#748075]">Tanya roadmap, skill gap, hingga persiapan interview kapan pun kamu butuh.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── FEATURED JOBS ───────────────────────────────────────────── --}}
<section id="jobs" class="mx-auto max-w-7xl px-5 py-20 lg:px-8">
    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-[#84b931]">Curated opportunities</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-[-0.04em]">Peluang yang mungkin cocok.</h2>
        </div>
        <a href="{{ route('jobs.index') }}" class="flex items-center gap-2 self-start text-sm font-bold text-[#6b9c2b] sm:self-auto">
            Lihat semua lowongan
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </div>
    <div class="mt-8 grid gap-4 lg:grid-cols-3">
        @forelse($latestJobs ?? [] as $job)
        <div class="rounded-2xl border border-[#e2eae0] bg-white p-5 transition hover:-translate-y-1 hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex gap-3">
                    <div class="grid size-11 place-items-center rounded-xl bg-[#d9f99d] text-lg font-bold text-[#2f4432]">{{ substr($job->company->name, 0, 1) }}</div>
                    <div>
                        <h3 class="font-semibold">{{ $job->title }}</h3>
                        <p class="mt-1 text-xs text-[#7b877e]">{{ $job->company->name }}</p>
                    </div>
                </div>
                <span class="rounded-full bg-[#edf8d5] px-2.5 py-1 text-xs font-bold text-[#69942f]">Baru</span>
            </div>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach(array_slice($job->skills_required ?? [], 0, 3) as $skill)
                    <span class="rounded-md bg-[#f2f5ef] px-2 py-1 text-[11px] text-[#637064]">{{ $skill }}</span>
                @endforeach
            </div>
            <div class="mt-5 flex items-center justify-between text-xs text-[#7e897f]">
                <span>{{ $job->location }} · {{ $job->work_type_label }}</span>
                <span class="font-semibold text-[#536356]">{{ $job->salary_range ?? 'Negotiable' }}</span>
            </div>
        </div>
        @empty
        @foreach([
            ['role' => 'Frontend Developer', 'company' => 'KitaKarya Digital', 'place' => 'Surabaya · Hybrid', 'salary' => 'Rp 7–10 jt', 'color' => 'bg-[#d9f99d]', 'skills' => ['React','JavaScript','CSS']],
            ['role' => 'Product Designer', 'company' => 'Loka Studio', 'place' => 'Jakarta · Remote', 'salary' => 'Rp 8–12 jt', 'color' => 'bg-[#bfdbfe]', 'skills' => ['Figma','UI/UX','Prototyping']],
            ['role' => 'Growth Marketing Lead', 'company' => 'Maju Bersama', 'place' => 'Bandung · On-site', 'salary' => 'Rp 9–14 jt', 'color' => 'bg-[#fed7aa]', 'skills' => ['Marketing','SEO','Analytics']],
        ] as $job)
        <div class="rounded-2xl border border-[#e2eae0] bg-white p-5 transition hover:-translate-y-1 hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex gap-3">
                    <div class="grid size-11 place-items-center rounded-xl {{ $job['color'] }} text-lg font-bold text-[#2f4432]">{{ substr($job['company'], 0, 1) }}</div>
                    <div>
                        <h3 class="font-semibold">{{ $job['role'] }}</h3>
                        <p class="mt-1 text-xs text-[#7b877e]">{{ $job['company'] }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($job['skills'] as $skill)
                    <span class="rounded-md bg-[#f2f5ef] px-2 py-1 text-[11px] text-[#637064]">{{ $skill }}</span>
                @endforeach
            </div>
            <div class="mt-5 flex items-center justify-between text-xs text-[#7e897f]">
                <span>{{ $job['place'] }}</span>
                <span class="font-semibold text-[#536356]">{{ $job['salary'] }}</span>
            </div>
        </div>
        @endforeach
        @endforelse
    </div>
</section>

{{-- ── CAREER AGENT CTA ────────────────────────────────────────── --}}
<section id="agent" class="mx-5 mb-20 overflow-hidden rounded-[2rem] bg-[#dff7a5] px-6 py-12 lg:mx-auto lg:max-w-7xl lg:px-16 lg:py-16">
    <div class="grid gap-10 lg:grid-cols-[1fr_.8fr] lg:items-center">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full bg-white/60 px-3 py-2 text-xs font-bold text-[#62852e]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                CAREER AGENT via Telegram
            </div>
            <h2 class="mt-5 max-w-xl text-4xl font-semibold leading-tight tracking-[-0.05em]">Punya pertanyaan soal karier? Mulai dari sini.</h2>
            <p class="mt-4 max-w-lg leading-7 text-[#526148]">Career Agent membantu kamu memahami posisi yang cocok, skill yang perlu dikuatkan, dan langkah berikutnya — langsung di Telegram kamu.</p>
            <a href="https://t.me/{{ config('services.telegram.bot_username', 'nineteenjobs_bot') }}" target="_blank" class="mt-7 inline-flex items-center gap-2 rounded-full bg-[#18251a] px-5 py-3 text-sm font-bold text-white">
                Buka di Telegram
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
        <div class="rounded-3xl bg-white/80 p-5 shadow-lg">
            <div class="flex items-center gap-3 border-b border-[#e5efd9] pb-4">
                <div class="grid size-10 place-items-center rounded-full bg-[#b7f34a]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold">Career Agent</p>
                    <p class="text-xs text-[#82907f]">Online · siap membantu</p>
                </div>
            </div>
            <div class="mt-5 rounded-2xl rounded-tl-sm bg-[#f2f6ed] p-3 text-sm leading-6 text-[#566354]">Halo! Saya bisa membantu kamu menemukan arah karier yang lebih jelas. Skill apa yang sedang kamu kembangkan?</div>
            <div class="mt-3 ml-8 rounded-2xl rounded-tr-sm bg-[#1f3026] p-3 text-sm leading-6 text-white">Saya ingin menjadi frontend developer. Mulai dari mana?</div>
            <div class="mt-3 flex items-center gap-2 text-xs text-[#7c8978]">
                <span class="size-1.5 animate-pulse rounded-full bg-[#88bf36]"></span>
                Career Agent sedang mengetik...
            </div>
        </div>
    </div>
</section>

{{-- ── FOOTER ──────────────────────────────────────────────────── --}}
<footer class="border-t border-[#e5ece1] px-5 py-8 lg:px-8">
    <div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 text-xs text-[#829084] sm:flex-row sm:items-center">
        <a href="/" class="flex items-center gap-2.5">
            <div class="grid size-6 place-items-center rounded-lg bg-[#b7f34a] text-[#12210d]">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
            </div>
            <span class="text-sm font-bold tracking-[-0.04em] text-[#16221b]">nineteen<span class="text-[#82b72d]">jobs</span></span>
        </a>
        <span>© {{ date('Y') }} NineteenJobs. Your skills. Your career.</span>
        <div class="flex gap-6">
            <a href="#" class="hover:text-[#3d5240]">Tentang Kami</a>
            <a href="#" class="hover:text-[#3d5240]">Kebijakan Privasi</a>
            <a href="#" class="hover:text-[#3d5240]">Syarat & Ketentuan</a>
        </div>
    </div>
</footer>
@endsection
