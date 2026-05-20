@extends('layouts.app')
@section('title', 'Laporan Stok')
@section('page-title', 'Laporan Stok')

@section('content')

{{-- ===== TOMBOL AKSI EXPORT ===== --}}
<div class="flex flex-wrap items-center gap-2 mb-5">

  {{-- Cetak PDF --}}
  <a href="{{ route('laporan.pdf') }}" target="_blank"
     class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm hover:opacity-90 transition-opacity"
     style="background:#c0392b">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
      <path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/>
    </svg>
    Cetak PDF
  </a>

  {{-- Export Excel --}}
  <a href="{{ route('laporan.excel') }}"
     class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm hover:opacity-90 transition-opacity"
     style="background:#1a7a4a">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
      <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3l4 4h-3v4h-2v-4H8l4-4zm-5 9h10v2H7v-2z"/>
    </svg>
    Export Excel
  </a>

  {{-- Print Halaman --}}
  <button onclick="window.print()"
          class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm hover:opacity-90 transition-opacity"
          style="background:#1e3a5f">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
      <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
    </svg>
    Print Halaman
  </button>

</div>

{{-- ===== TABEL LAPORAN ===== --}}
<div id="area-print" class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">

  {{-- Judul (hanya tampil saat print) --}}
  <div class="hidden print:block px-6 py-4 border-b border-slate-200">
    <h2 class="text-lg font-bold text-slate-800">Laporan Stok Barang</h2>
    <p class="text-sm text-slate-500">BAN-PDM Papua Barat &mdash; Dicetak: {{ now()->translatedFormat('d F Y') }}</p>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-xs font-bold text-white uppercase"
            style="background: linear-gradient(90deg, #1e3a5f, #2a4f80)">
          <th class="px-4 py-3 text-left">No</th>
          <th class="px-4 py-3 text-left">Kode</th>
          <th class="px-4 py-3 text-left">Nama Barang</th>
          <th class="px-4 py-3 text-left">Kategori</th>
          <th class="px-4 py-3 text-left">Unit</th>
          <th class="px-4 py-3 text-center">Stok</th>
          <th class="px-4 py-3 text-center">Min</th>
          <th class="px-4 py-3 text-center">Total Masuk</th>
          <th class="px-4 py-3 text-center">Total Keluar</th>
          <th class="px-4 py-3 text-center">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse($items as $i => $item)
        <tr class="hover:bg-slate-50 transition-colors">
          <td class="px-4 py-3 text-slate-400 text-xs">{{ $i + 1 }}</td>
          <td class="px-4 py-3">
            <span class="font-mono text-xs px-2 py-0.5 rounded font-semibold"
                  style="background:#e8eef5; color:#1e3a5f">
              {{ $item->code }}
            </span>
          </td>
          <td class="px-4 py-3 font-semibold text-slate-800">{{ $item->name }}</td>
          <td class="px-4 py-3 text-slate-600">{{ $item->category->name ?? '-' }}</td>
          <td class="px-4 py-3 text-slate-600">{{ $item->unit->name ?? '-' }}</td>
          <td class="px-4 py-3 text-center font-bold
                     {{ $item->isLowStock() ? 'text-red-600' : '' }}"
              style="{{ !$item->isLowStock() ? 'color:#1e3a5f' : '' }}">
            {{ $item->stock }}
          </td>
          <td class="px-4 py-3 text-center text-slate-500">{{ $item->min_stock }}</td>
          <td class="px-4 py-3 text-center font-bold" style="color:#1a7a4a">
            +{{ $item->total_masuk }}
          </td>
          <td class="px-4 py-3 text-center font-bold text-red-600">
            -{{ $item->total_keluar }}
          </td>
          <td class="px-4 py-3 text-center">
            @if($item->isLowStock())
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-700">
                Perlu Restok
              </span>
            @else
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                    style="background:#e6f5ed; color:#145c37">
                Aman
              </span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="10" class="px-4 py-12 text-center text-slate-400">
            Tidak ada data barang.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Ringkasan bawah tabel --}}
  @if($items->count() > 0)
  <div class="px-5 py-3 border-t border-slate-100 flex flex-wrap gap-5 text-xs"
       style="background:#f8fafc">
    <span class="text-slate-500">
      Total barang:
      <strong class="font-bold" style="color:#1e3a5f">{{ $items->count() }}</strong>
    </span>
    <span class="text-slate-500">
      Stok aman:
      <strong class="font-bold" style="color:#1a7a4a">
        {{ $items->filter(fn($i) => !$i->isLowStock())->count() }}
      </strong>
    </span>
    <span class="text-slate-500">
      Perlu restok:
      <strong class="font-bold text-red-600">
        {{ $items->filter(fn($i) => $i->isLowStock())->count() }}
      </strong>
    </span>
  </div>
  @endif

</div>

{{-- CSS Print --}}
<style>
  @media print {
    aside, header, .flex.flex-wrap.items-center { display: none !important; }
    .ml-64 { margin-left: 0 !important; }
    main { padding: 0 !important; }
    .print\:block { display: block !important; }
  }
</style>

@endsection
