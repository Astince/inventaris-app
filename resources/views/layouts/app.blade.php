<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Inventaris') — BAN-PDM Papua Barat</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  // Daftarkan warna custom tema BAN-PDM
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          navy:   { DEFAULT: '#1e3a5f', light: '#2a4f80', dark: '#152b47', muted: '#e8eef5' },
          gold:   { DEFAULT: '#f5c518', light: '#fdd84e', dark: '#d4a800', muted: '#fef9e7' },
          forest: { DEFAULT: '#1a7a4a', light: '#22a060', dark: '#145c37', muted: '#e6f5ed' },
        }
      }
    }
  }
</script>
</head>
<body class="bg-slate-100 font-sans">
<div class="flex min-h-screen">

{{-- ===== SIDEBAR ===== --}}
<aside class="w-64 flex flex-col fixed top-0 left-0 bottom-0 z-50"
       style="background: linear-gradient(180deg, #1e3a5f 0%, #152b47 100%);">

  {{-- Logo & Nama Kantor --}}
  <div class="px-4 py-5 border-b border-white/10">
    <div class="flex items-center gap-3">
      <img src="{{ asset('images/logo.png') }}" alt="Logo BAN-PDM"
           class="w-12 h-12 object-contain flex-shrink-0 drop-shadow-md">
      <div>
        <div class="text-base font-bold text-white leading-tight">BAN-PDM</div>
        <div class="text-xs text-yellow-300 font-medium">Papua Barat</div>
        <div class="text-[10px] text-blue-200 mt-0.5">Sistem Inventaris</div>
      </div>
    </div>
  </div>

  {{-- Navigasi --}}
  <nav class="flex-1 px-3 py-3 overflow-y-auto space-y-0.5">

    <p class="text-[10px] font-bold text-blue-300/70 uppercase tracking-widest px-2 pt-2 pb-1.5">
      Menu Utama
    </p>

    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('dashboard')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
      </svg>
      Dashboard
    </a>

    <a href="{{ route('barang.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('barang.*')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M20 6h-2.18c.07-.44.18-.88.18-1.36C18 2.08 15.92 0 13.36 0c-1.3 0-2.48.5-3.36 1.3C9.12.5 7.94 0 6.64 0 4.08 0 2 2.08 2 4.64c0 .48.11.92.18 1.36H0v14h2v2h20v-2h2V6h-4zM8 8h8v12H8V8z"/>
      </svg>
      Master Barang
    </a>

    <a href="{{ route('transaksi.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('transaksi.*')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-5h2v5zm4 0h-2V7h2v10zm4 0h-2v-3h2v3z"/>
      </svg>
      Transaksi Barang
    </a>

    <a href="{{ route('laporan.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('laporan.*')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
      </svg>
      Laporan Stok
    </a>

    <a href="{{ route('riwayat.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('riwayat.*')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
      </svg>
      Riwayat Transaksi
    </a>

    @if(auth()->user()->role === 'superadmin')
    <p class="text-[10px] font-bold text-blue-300/70 uppercase tracking-widest px-2 pt-4 pb-1.5">
      Master Data
    </p>

    <a href="{{ route('kategori.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('kategori.*')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 2l-5.5 9h11zm5.5 11c-2.49 0-4.5 2.01-4.5 4.5S15.01 22 17.5 22 22 19.99 22 17.5 19.99 13 17.5 13zm-10 .5h-5v5h5v-5z"/>
      </svg>
      Kategori Barang
    </a>

    <a href="{{ route('unit.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('unit.*')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
      </svg>
      Unit Barang
    </a>

    <a href="{{ route('users.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('users.*')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
      </svg>
      Kelola User
    </a>

    <p class="text-[10px] font-bold text-blue-300/70 uppercase tracking-widest px-2 pt-4 pb-1.5">
      Sistem
    </p>

    <a href="{{ route('auditlog.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
              {{ request()->routeIs('auditlog.*')
                 ? 'bg-yellow-400 text-navy font-bold shadow-md'
                 : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/>
      </svg>
      Audit Log
    </a>
    @endif

  </nav>

  {{-- Info User & Logout --}}
  <div class="px-3 py-3 border-t border-white/10">
    <div class="flex items-center gap-2.5 bg-white/10 rounded-xl px-3 py-2.5">
      {{-- Avatar inisial --}}
      <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 text-navy"
           style="background: linear-gradient(135deg, #f5c518, #fdd84e);">
        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
      </div>
      <div class="flex-1 min-w-0">
        <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
        <div class="text-xs text-yellow-300 capitalize">{{ auth()->user()->role }}</div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
                class="text-xs text-blue-200 hover:text-red-300 border border-white/20 hover:border-red-400/50
                       px-2 py-1 rounded-lg transition-colors"
                title="Keluar">
          <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
          </svg>
        </button>
      </form>
    </div>
  </div>

</aside>

{{-- ===== KONTEN UTAMA ===== --}}
<div class="ml-64 flex-1 flex flex-col min-h-screen">

  {{-- Topbar --}}
  <header class="bg-white border-b border-slate-200 h-14 flex items-center justify-between px-6 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center gap-3">
      {{-- Garis aksen kuning --}}
      <div class="w-1 h-6 rounded-full" style="background:#f5c518"></div>
      <h1 class="text-sm font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
    </div>
    <div class="flex items-center gap-3">
      <span class="text-xs text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</span>
      {{-- Badge nama kantor --}}
      <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full text-white"
            style="background:#1e3a5f">
        <svg class="w-3 h-3 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
        </svg>
        BAN-PDM Papua Barat
      </span>
    </div>
  </header>

  {{-- Area Konten --}}
  <main class="flex-1 p-6">

    {{-- Flash: Sukses --}}
    @if(session('success'))
    <div class="mb-4 rounded-xl px-4 py-3 text-sm flex items-center gap-2 border"
         style="background:#e6f5ed; border-color:#86efac; color:#145c37">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
      </svg>
      {{ session('success') }}
    </div>
    @endif

    {{-- Flash: Error --}}
    @if(session('error'))
    <div class="mb-4 rounded-xl px-4 py-3 text-sm flex items-center gap-2 border border-red-200 bg-red-50 text-red-700">
      <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
      </svg>
      {{ session('error') }}
    </div>
    @endif

    @yield('content')
  </main>
</div>

</div>
</body>
</html>
