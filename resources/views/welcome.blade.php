@extends('layouts.guest')

@section('title', 'NineteenJobs — AI-powered Career Platform')

@section('content')
<div class="page-shell">

  {{-- ── TOPBAR ──────────────────────────────────────────────── --}}
  <header class="topbar">
    <a href="/" class="brand-wrap">
      <div class="brand-mark">19</div>
      <div class="brand-text">
        <span>NineteenJobs</span>
        <small>CAREER AI</small>
      </div>
    </a>

    <nav class="nav-menu" aria-label="Navigasi utama">
      <a href="#produk">Produk</a>
      <a href="#fitur">Fitur</a>
      <a href="#pelamar">Pelamar</a>
      <a href="#testimoni">Testimoni</a>
    </nav>

    <div class="nav-actions">
      <button id="themeToggle" class="theme-toggle" type="button" aria-label="Toggle dark mode">
        <span class="theme-icon">☀️</span>
      </button>
      @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Coba Gratis</a>
      @endauth
    </div>
  </header>

  <main>

    {{-- ── HERO ─────────────────────────────────────────────────── --}}
    <section class="hero">
      <div class="hero-copy">
        <span class="eyebrow">AI-powered hiring platform</span>
        <h1>Temukan peluang kerja yang cocok dengan kemampuanmu, bukan sekadar pencarian biasa.</h1>
        <p>NineteenJobs menghubungkan pencari kerja dan perusahaan dengan sistem rekomendasi pintar, screening otomatis, serta roadmap karier yang lebih cepat dan lebih tepat sasaran.</p>

        <div class="cta-group">
          <a href="{{ route('register') }}" class="btn btn-primary large">Mulai Karier</a>
          <button id="demoButton" class="btn btn-secondary large" type="button">Lihat Demo</button>
        </div>

        <div class="mini-metric-row">
          <div>
            <strong>{{ number_format($stats['talents'] ?? 120) }}K+</strong>
            <span>talent aktif</span>
          </div>
          <div>
            <strong>96%</strong>
            <span>match accuracy</span>
          </div>
          <div>
            <strong>12 jam</strong>
            <span>rata-rata respon</span>
          </div>
        </div>
      </div>

      {{-- Hero visual --}}
      <div class="hero-visual" aria-label="Preview platform">
        <div class="dashboard-window">
          <div class="window-header">
            <span class="dot red"></span>
            <span class="dot yellow"></span>
            <span class="dot green"></span>
          </div>

          <div class="dashboard-content">
            <div class="profile-card">
              <div class="avatar">A</div>
              <div>
                <h3>Axelia Agatha</h3>
                <p>Product Designer • Remote</p>
              </div>
            </div>

            <div class="score-box">
              <div class="score-text">
                <small>AI Match Score</small>
                <strong>96%</strong>
              </div>
              <div class="score-ring">96</div>
            </div>

            <div class="job-card featured">
              <div class="job-topline">
                <span class="chip success">Recommended</span>
                <span class="chip neutral">Remote</span>
              </div>
              <h4>Senior Product Designer</h4>
              <p>Northstar Labs • Jakarta</p>
              <div class="job-meta">
                <span>Rp 14–18 jt</span>
                <span>Full-time</span>
              </div>
            </div>

            <div class="job-list">
              <div class="mini-job">
                <div>
                  <strong>Frontend Engineer</strong>
                  <span>Bytewise Studio</span>
                </div>
                <span class="match-tag">94%</span>
              </div>
              <div class="mini-job">
                <div>
                  <strong>AI Researcher</strong>
                  <span>Nova Horizon</span>
                </div>
                <span class="match-tag">92%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- ── PARTNER STRIP ─────────────────────────────────────── --}}
    <section class="partner-strip" aria-label="Brand partner">
      <span>Dipercaya oleh tim dari:</span>
      <div class="brand-row">
        <span>Slack</span>
        <span>Notion</span>
        <span>Stripe</span>
        <span>Shopify</span>
        <span>Airbnb</span>
      </div>
    </section>

    {{-- ── FITUR ─────────────────────────────────────────────── --}}
    <section id="fitur" class="feature-section">
      <div class="section-heading">
        <span class="eyebrow">Kenapa NineteenJobs?</span>
        <h2>Semua yang dibutuhkan untuk hiring yang lebih cerdas.</h2>
      </div>

      <div class="feature-grid">
        <article class="feature-card">
          <div class="icon-box blue">⚡</div>
          <h3>AI Matching</h3>
          <p>Menganalisis skill, portfolio, dan preferensi karier untuk menampilkan pekerjaan paling relevan.</p>
        </article>
        <article class="feature-card">
          <div class="icon-box purple">🧠</div>
          <h3>Screening Otomatis</h3>
          <p>NineteenJobs memprioritaskan kandidat terbaik dan menyingkat waktu review recruiter secara signifikan.</p>
        </article>
        <article class="feature-card">
          <div class="icon-box orange">📈</div>
          <h3>Roadmap Karier</h3>
          <p>Memberikan saran skill yang harus ditingkatkan agar peluang kerja naik dengan cepat.</p>
        </article>
      </div>
    </section>

    {{-- ── PRODUK (Match) ────────────────────────────────────── --}}
    <section id="produk" class="match-section">
      <div class="section-heading left-aligned" style="max-width:1180px;margin-left:auto;margin-right:auto">
        <span class="eyebrow">Pekerjaan yang paling cocok</span>
        <h2>Rekomendasi berdasarkan profil, performance, dan tren pasar.</h2>
      </div>

      <div class="match-layout">
        <div class="job-panel">
          <div class="job-head">
            <h3>Pilihan paling relevan</h3>
            <button class="mini-btn">Filter</button>
          </div>

          <div class="listing-card active">
            <div class="listing-top">
              <div>
                <span class="chip success">96% Match</span>
                <h4>Frontend Developer</h4>
              </div>
              <span class="salary">Rp 8–12 jt</span>
            </div>
            <p>Nova Digital • Remote • Full-time</p>
            <div class="tag-row">
              <span>React</span><span>UI/UX</span><span>TypeScript</span>
            </div>
          </div>

          <div class="listing-card">
            <div class="listing-top">
              <div>
                <span class="chip success">92% Match</span>
                <h4>Product Analyst</h4>
              </div>
              <span class="salary">Rp 10–15 jt</span>
            </div>
            <p>Velora Labs • Hybrid • Full-time</p>
            <div class="tag-row">
              <span>SQL</span><span>Figma</span><span>Analytics</span>
            </div>
          </div>

          <div class="listing-card">
            <div class="listing-top">
              <div>
                <span class="chip success">89% Match</span>
                <h4>Growth Marketing</h4>
              </div>
              <span class="salary">Rp 9–13 jt</span>
            </div>
            <p>Bloomify • On-site • Contract</p>
            <div class="tag-row">
              <span>SEO</span><span>Ads</span><span>CRM</span>
            </div>
          </div>
        </div>

        <aside class="insight-panel">
          <div class="insight-header">
            <span class="glow-dot"></span>
            <h3>AI insight</h3>
          </div>
          <div class="insight-box">
            <p>Profil Anda paling kuat di:</p>
            <ul>
              <li>UI/UX thinking</li>
              <li>Prototyping &amp; design systems</li>
              <li>Cross-functional collaboration</li>
            </ul>
          </div>
          <div class="grow-card">
            <small>Skill booster</small>
            <strong>Belajar React + motion design</strong>
            <span>+18% peluang interview</span>
          </div>
        </aside>
      </div>
    </section>

    {{-- ── CARA KERJA ─────────────────────────────────────────── --}}
    <section class="process-section">
      <div class="section-heading center-aligned">
        <span class="eyebrow">Cara kerjanya</span>
        <h2>Proses yang cepat, jelas, dan lebih manusiawi.</h2>
      </div>

      <div class="process-grid">
        <div class="process-card">
          <span class="step-number">01</span>
          <h3>Buat profil</h3>
          <p>Isi data, pengalaman, dan kebutuhan karier Anda dengan mudah.</p>
        </div>
        <div class="process-card">
          <span class="step-number">02</span>
          <h3>AI scan</h3>
          <p>Sistem membaca keahlian dan menyarankan pekerjaan yang paling sesuai.</p>
        </div>
        <div class="process-card">
          <span class="step-number">03</span>
          <h3>Apply &amp; interview</h3>
          <p>Level up peluang dengan shortcut apply dan jadwal interview yang lebih efisien.</p>
        </div>
      </div>
    </section>

    {{-- ── TESTIMONI ──────────────────────────────────────────── --}}
    <section id="pelamar" class="testimonial-section">
      <div class="section-heading left-aligned" style="max-width:1180px;margin-left:auto;margin-right:auto">
        <span class="eyebrow">Cerita pelamar</span>
        <h2>Yang kami bantu, mendapatkan kesempatan yang lebih cepat.</h2>
      </div>

      <div class="testimonial-grid" style="max-width:1180px;margin:0 auto">
        <article class="quote-card">
          <p>"Saya dapat 3 interview dalam 2 minggu setelah memakai platform ini. AI matching-nya sangat akurat."</p>
          <div class="person">
            <span class="avatar small">R</span>
            <div><strong>Rina</strong><small>Product Designer</small></div>
          </div>
        </article>
        <article class="quote-card">
          <p>"Interfacing-nya sangat mudah dan tidak membingungkan. Fitur rekomendasi pekerjaan terasa personal."</p>
          <div class="person">
            <span class="avatar small alt">D</span>
            <div><strong>Dimas</strong><small>Frontend Engineer</small></div>
          </div>
        </article>
      </div>
    </section>

    {{-- ── CTA BANNER ─────────────────────────────────────────── --}}
    <section id="testimoni" class="cta-banner">
      <div>
        <span class="eyebrow light">Siap mulai?</span>
        <h2>Bangun karier berikutnya dengan teknologi yang tepat.</h2>
      </div>
      <a href="{{ route('register') }}" class="btn btn-secondary large">Daftar Sekarang</a>
    </section>

  </main>

  <footer class="site-footer">
    <a href="/" class="brand-wrap">
      <div class="brand-mark">19</div>
      <div class="brand-text">
        <span>NineteenJobs</span>
        <small>CAREER AI</small>
      </div>
    </a>
    <p>© {{ date('Y') }} NineteenJobs. Semua hak dilindungi.</p>
  </footer>

</div>

{{-- ── AUTH MODAL ──────────────────────────────────────────── --}}
<div id="authModal" class="modal-backdrop" hidden>
  <section class="auth-modal" role="dialog" aria-modal="true" aria-labelledby="authTitle">
    <button id="closeModalButton" class="modal-close" type="button" aria-label="Tutup">&times;</button>
    <div class="auth-heading">
      <span class="eyebrow">NineteenJobs account</span>
      <h2 id="authTitle">Masuk ke akunmu</h2>
      <p id="authSubtitle">Simpan profil dan rekomendasi kerja favoritmu.</p>
    </div>
    <div class="auth-tabs" role="tablist">
      <button class="auth-tab active" type="button" data-auth-mode="login">Masuk</button>
      <button class="auth-tab" type="button" data-auth-mode="signup">Daftar</button>
    </div>
    <form id="authForm" style="display:flex;flex-direction:column;gap:14px">
      <label id="nameField" class="form-field" hidden>Nama lengkap<input id="nameInput" type="text" autocomplete="name" placeholder="Contoh: Axelia Agatha"/></label>
      <label class="form-field">Email<input id="emailInput" type="email" autocomplete="email" placeholder="nama@email.com" required/></label>
      <label class="form-field">Password<input id="passwordInput" type="password" autocomplete="current-password" placeholder="Minimal 6 karakter" minlength="6" required/></label>
      <p id="authMessage" class="form-message" role="status"></p>
      <button id="authSubmit" class="btn btn-primary auth-submit" type="submit">Masuk</button>
    </form>
    <div id="profileView" class="profile-view" hidden>
      <div id="profileAvatar" class="avatar">A</div>
      <div><strong id="profileName">Nama pengguna</strong><span id="profileEmail">email@example.com</span></div>
      <button id="logoutButton" class="btn btn-ghost" type="button">Keluar</button>
    </div>
  </section>
</div>

{{-- ── DEMO MODAL ──────────────────────────────────────────── --}}
<div id="demoModal" class="modal-backdrop" hidden>
  <section class="demo-modal" role="dialog" aria-modal="true" aria-labelledby="demoTitle">
    <button id="closeDemoButton" class="modal-close" type="button" aria-label="Tutup demo">&times;</button>
    <div class="demo-heading">
      <span class="eyebrow">Simulasi NineteenJobs</span>
      <h2 id="demoTitle">Mulai dari sisi yang kamu butuhkan</h2>
      <p>Platform yang menjembatani pencari kerja dan penyedia kerja dalam satu alur yang transparan.</p>
    </div>

    <div id="demoRoleStep" class="demo-step">
      <div class="demo-role-grid">
        <button class="demo-role-card" type="button" data-demo-role="seeker">
          <span class="demo-role-icon">↗</span>
          <strong>Saya pencari kerja</strong>
          <span>Isi profil dan CV, dapatkan match, lalu pantau respon perusahaan.</span>
        </button>
        <button class="demo-role-card" type="button" data-demo-role="employer">
          <span class="demo-role-icon">⌁</span>
          <strong>Saya penyedia kerja</strong>
          <span>Publikasikan lowongan dan temukan kandidat yang paling relevan.</span>
        </button>
      </div>
    </div>

    <form id="seekerDemoForm" class="demo-step demo-form" hidden style="display:none;flex-direction:column;gap:14px">
      <div class="demo-step-heading">
        <span class="step-number">01</span>
        <div><h3 style="font-size:16px;font-weight:700;color:var(--text)">Profil pencari kerja</h3><p style="font-size:13px;color:var(--text-muted)">Ceritakan sedikit tentang dirimu.</p></div>
      </div>
      <div class="demo-form-grid">
        <label class="form-field">Nama lengkap<input id="seekerName" type="text" placeholder="Contoh: Axelia Agatha" required/></label>
        <label class="form-field">Email<input id="seekerEmail" type="email" placeholder="nama@email.com" required/></label>
        <label class="form-field">Role yang dicari<select id="seekerRole" required><option value="">Pilih role</option><option>Product Designer</option><option>Frontend Engineer</option><option>Product Analyst</option><option>Growth Marketing</option></select></label>
        <label class="form-field">Lokasi kerja<select id="seekerLocation"><option>Remote</option><option>Jakarta</option><option>Bandung</option><option>Hybrid</option></select></label>
      </div>
      <label class="cv-upload"><span class="upload-icon">↑</span><strong id="cvFileLabel">Upload CV / resume</strong><span>PDF atau DOCX, maksimal 10 MB</span><input id="seekerCv" type="file" accept=".pdf,.doc,.docx" required/></label>
      <div class="demo-form-actions">
        <button class="mini-btn demo-back" type="button">Kembali</button>
        <button class="btn btn-primary" type="submit">Analisis Profil &amp; CV</button>
      </div>
    </form>

    <form id="employerDemoForm" class="demo-step demo-form" hidden style="display:none;flex-direction:column;gap:14px">
      <div class="demo-step-heading">
        <span class="step-number">01</span>
        <div><h3 style="font-size:16px;font-weight:700;color:var(--text)">Profil penyedia kerja</h3><p style="font-size:13px;color:var(--text-muted)">Publikasikan kebutuhan tim.</p></div>
      </div>
      <div class="demo-form-grid">
        <label class="form-field">Nama perusahaan<input id="companyName" type="text" placeholder="Contoh: Northstar Labs" required/></label>
        <label class="form-field">Email recruiter<input id="companyEmail" type="email" placeholder="recruiter@company.com" required/></label>
        <label class="form-field">Posisi yang dibuka<input id="companyRole" type="text" placeholder="Contoh: Senior Product Designer" required/></label>
        <label class="form-field">Model kerja<select id="companyLocation"><option>Remote</option><option>Hybrid</option><option>On-site</option></select></label>
      </div>
      <label class="form-field">Deskripsi pekerjaan<textarea id="companyDescription" rows="3" placeholder="Tulis skill dan tanggung jawab utama..." required></textarea></label>
      <div class="demo-form-actions">
        <button class="mini-btn demo-back" type="button">Kembali</button>
        <button class="btn btn-primary" type="submit">Cari Kandidat</button>
      </div>
    </form>

    <div id="seekerDemoResult" class="demo-result" hidden>
      <div class="result-banner success-banner"><span class="result-icon">✓</span><div><strong>Profil berhasil dianalisis</strong><span id="seekerResultSummary">Match ditemukan berdasarkan CV dan preferensimu.</span></div></div>
      <div class="result-grid">
        <div class="result-score"><small>CV health score</small><strong>84<span>/100</span></strong><span class="score-up">+18% setelah optimasi AI</span></div>
        <div class="result-insight"><small>AI menemukan kekuatanmu</small><strong>Product thinking, Figma, dan kolaborasi lintas tim</strong><span>Yang perlu diperkuat: impact metrics dan keyword ATS.</span></div>
      </div>
      <div class="result-section-title"><div><small>Rekomendasi untukmu</small><h3>3 perusahaan tertarik dengan profilmu</h3></div><span class="chip success">89% average match</span></div>
      <div class="response-list">
        <article><div class="avatar small">N</div><div><strong>Northstar Labs</strong><span>Senior Product Designer • 96% match</span><small>"Kami ingin mengundangmu ke tahap portfolio review."</small></div><button class="mini-btn response-action" type="button">Lihat detail</button></article>
        <article><div class="avatar small alt">V</div><div><strong>Velora Labs</strong><span>Product Analyst • 82% match</span><small>Status: profil sedang direview recruiter</small></div><button class="mini-btn response-action" type="button">Pantau</button></article>
      </div>
      <div class="paid-feature"><span class="paid-badge">PRO</span><div><strong>Perbaiki CV dengan AI</strong><span>Dapatkan 7 saran spesifik untuk menaikkan skor ATS.</span></div><button id="unlockCvAi" class="btn btn-primary" type="button">Coba AI Pro</button></div>
      <button class="mini-btn demo-restart" type="button">Coba peran lain</button>
    </div>

    <div id="employerDemoResult" class="demo-result" hidden>
      <div class="result-banner success-banner"><span class="result-icon">✓</span><div><strong>Lowongan siap ditayangkan</strong><span id="employerResultSummary">NineteenJobs menemukan kandidat terbaik.</span></div></div>
      <div class="result-section-title"><div><small>Candidate matching</small><h3>2 kandidat paling relevan</h3></div><span class="chip success">AI ranked</span></div>
      <div class="candidate-list">
        <article><div class="avatar small">R</div><div><strong>Raka Pratama</strong><span>Product Designer • 96% match</span><small>Figma, design systems, 5 tahun pengalaman</small></div><button class="mini-btn response-action" type="button">Hubungi</button></article>
        <article><div class="avatar small alt">S</div><div><strong>Salsa Putri</strong><span>Product Designer • 91% match</span><small>Research, prototyping, dan mobile product</small></div><button class="mini-btn response-action" type="button">Hubungi</button></article>
      </div>
      <div class="paid-feature"><span class="paid-badge">BOOST</span><div><strong>Pin lowongan di beranda pencari kerja</strong><span>Posisikan lowongan di paling atas selama 7 hari.</span></div><button id="pinJobButton" class="btn btn-primary" type="button">Pin lowongan</button></div>
      <div class="paid-feature"><span class="paid-badge">AI</span><div><strong>AI screening otomatis</strong><span>Urutkan kandidat berdasarkan skill dan kecocokan deskripsi.</span></div><button id="unlockScreening" class="btn btn-secondary" type="button">Aktifkan Pro</button></div>
      <button class="mini-btn demo-restart" type="button">Coba peran lain</button>
    </div>

    <p id="demoMessage" class="demo-message" role="status"></p>
  </section>
</div>

<script>
  // ── Dark mode toggle ──────────────────────────────────────────
  const themeToggle = document.getElementById('themeToggle');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const storedTheme = localStorage.getItem('nineteenjobs-theme');

  function applyTheme(theme) {
    document.body.setAttribute('data-theme', theme);
    themeToggle.querySelector('.theme-icon').textContent = theme === 'dark' ? '🌙' : '☀️';
  }

  applyTheme(storedTheme || (prefersDark ? 'dark' : 'light'));

  themeToggle.addEventListener('click', () => {
    const next = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    localStorage.setItem('nineteenjobs-theme', next);
    applyTheme(next);
  });

  // ── Auth modal ───────────────────────────────────────────────
  const authModal   = document.getElementById('authModal');
  const authForm    = document.getElementById('authForm');
  const authTitle   = document.getElementById('authTitle');
  const authSubtitle= document.getElementById('authSubtitle');
  const authSubmit  = document.getElementById('authSubmit');
  const authMessage = document.getElementById('authMessage');
  const nameField   = document.getElementById('nameField');
  const nameInput   = document.getElementById('nameInput');
  const emailInput  = document.getElementById('emailInput');
  const passwordInput = document.getElementById('passwordInput');
  const profileView = document.getElementById('profileView');
  let authMode = 'login';

  function getUsers() { return JSON.parse(localStorage.getItem('nj-users') || '[]'); }

  function openAuth(mode = 'login') {
    authMode = mode;
    authModal.hidden = false;
    authForm.style.display = 'flex';
    profileView.hidden = true;
    authMessage.textContent = '';
    document.querySelectorAll('[data-auth-mode]').forEach(t => t.classList.toggle('active', t.dataset.authMode === mode));
    nameField.hidden = mode !== 'signup';
    nameInput.required = mode === 'signup';
    authTitle.textContent   = mode === 'signup' ? 'Buat akun NineteenJobs' : 'Masuk ke akunmu';
    authSubtitle.textContent= mode === 'signup' ? 'Mulai simpan profil dan temukan peluang yang cocok.' : 'Simpan profil dan rekomendasi kerja favoritmu.';
    authSubmit.textContent  = mode === 'signup' ? 'Buat Akun' : 'Masuk';
    (mode === 'signup' ? nameInput : emailInput).focus();
  }

  function closeAuth() { authModal.hidden = true; authForm.reset(); authMessage.textContent = ''; }

  function showProfile(user) {
    authForm.style.display = 'none';
    profileView.hidden = false;
    authTitle.textContent = 'Profilmu sudah aktif';
    authSubtitle.textContent = 'Akun tersimpan di perangkat ini.';
    document.getElementById('profileName').textContent  = user.name;
    document.getElementById('profileEmail').textContent = user.email;
    document.getElementById('profileAvatar').textContent = user.name.charAt(0).toUpperCase();
  }

  document.querySelectorAll('[data-auth-mode]').forEach(tab => tab.addEventListener('click', () => openAuth(tab.dataset.authMode)));
  document.getElementById('closeModalButton').addEventListener('click', closeAuth);
  authModal.addEventListener('click', e => { if (e.target === authModal) closeAuth(); });

  authForm.addEventListener('submit', e => {
    e.preventDefault();
    const email = emailInput.value.trim().toLowerCase();
    const password = passwordInput.value;
    const users = getUsers();
    const existing = users.find(u => u.email === email);

    if (authMode === 'signup') {
      if (existing) { authMessage.textContent = 'Email ini sudah terdaftar.'; return; }
      const user = { name: nameInput.value.trim(), email, password };
      localStorage.setItem('nj-users', JSON.stringify([...users, user]));
      localStorage.setItem('nj-current', JSON.stringify(user));
      showProfile(user); return;
    }
    if (!existing || existing.password !== password) { authMessage.textContent = 'Email atau password salah.'; return; }
    localStorage.setItem('nj-current', JSON.stringify(existing));
    showProfile(existing);
  });

  document.getElementById('logoutButton').addEventListener('click', () => {
    localStorage.removeItem('nj-current');
    closeAuth();
  });

  // ── Demo modal ───────────────────────────────────────────────
  const demoModal       = document.getElementById('demoModal');
  const demoMessage     = document.getElementById('demoMessage');
  const demoRoleStep    = document.getElementById('demoRoleStep');
  const seekerForm      = document.getElementById('seekerDemoForm');
  const employerForm    = document.getElementById('employerDemoForm');
  const seekerResult    = document.getElementById('seekerDemoResult');
  const employerResult  = document.getElementById('employerDemoResult');

  function showStep(show) {
    [demoRoleStep, seekerForm, employerForm, seekerResult, employerResult].forEach(el => {
      el.hidden = true; el.style.display = 'none';
    });
    show.hidden = false; show.style.display = 'flex';
  }

  function resetDemo() {
    demoRoleStep.hidden = false; demoRoleStep.style.display = 'block';
    [seekerForm, employerForm, seekerResult, employerResult].forEach(el => { el.hidden = true; el.style.display = 'none'; });
    seekerForm.reset(); employerForm.reset();
    document.getElementById('cvFileLabel').textContent = 'Upload CV / resume';
    demoMessage.textContent = 'Pilih peran untuk memulai simulasi.';
  }

  document.getElementById('demoButton').addEventListener('click', () => { demoModal.hidden = false; resetDemo(); });
  document.getElementById('closeDemoButton').addEventListener('click', () => { demoModal.hidden = true; });
  demoModal.addEventListener('click', e => { if (e.target === demoModal) demoModal.hidden = true; });

  document.querySelectorAll('[data-demo-role]').forEach(btn => btn.addEventListener('click', () => {
    const isSeeker = btn.dataset.demoRole === 'seeker';
    demoRoleStep.hidden = true; demoRoleStep.style.display = 'none';
    showStep(isSeeker ? seekerForm : employerForm);
    demoMessage.textContent = isSeeker ? 'Lengkapi data dan upload CV untuk melihat hasil analisis.' : 'Masukkan kebutuhan rekrutmen untuk melihat kandidat.';
  }));

  document.querySelectorAll('.demo-back').forEach(b => b.addEventListener('click', resetDemo));
  document.querySelectorAll('.demo-restart').forEach(b => b.addEventListener('click', resetDemo));

  document.getElementById('seekerCv').addEventListener('change', e => {
    if (e.target.files[0]) document.getElementById('cvFileLabel').textContent = e.target.files[0].name;
  });

  seekerForm.addEventListener('submit', e => {
    e.preventDefault();
    const name = document.getElementById('seekerName').value.trim();
    const role = document.getElementById('seekerRole').value;
    document.getElementById('seekerResultSummary').textContent = `${name}, CV-mu cocok untuk role ${role}.`;
    showStep(seekerResult);
    demoMessage.textContent = 'Analisis selesai. Lihat score dan match di bawah.';
  });

  employerForm.addEventListener('submit', e => {
    e.preventDefault();
    const company = document.getElementById('companyName').value.trim();
    const role    = document.getElementById('companyRole').value.trim();
    document.getElementById('employerResultSummary').textContent = `${company} • ${role} sudah diproses.`;
    showStep(employerResult);
    demoMessage.textContent = 'Matching kandidat selesai.';
  });

  document.querySelectorAll('.response-action').forEach(b => b.addEventListener('click', () => { b.textContent = b.textContent === 'Hubungi' ? 'Pesan terkirim ✓' : 'Terbuka ✓'; b.disabled = true; }));
  document.getElementById('unlockCvAi').addEventListener('click', e => { e.currentTarget.textContent = 'AI Pro aktif ✓'; e.currentTarget.disabled = true; });
  document.getElementById('pinJobButton').addEventListener('click', e => { e.currentTarget.textContent = 'Pinned ✓'; e.currentTarget.disabled = true; });
  document.getElementById('unlockScreening').addEventListener('click', e => { e.currentTarget.textContent = 'Screening aktif ✓'; e.currentTarget.disabled = true; });
</script>
@endsection
