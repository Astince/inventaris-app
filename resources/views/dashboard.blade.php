@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
  <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
    <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.36C18 2.08 15.92 0 13.36 0c-1.3 0-2.48.5-3.36 1.3C9.12.5 7.94 0 6.64 0 4.08 0 2 2.08 2 4.64c0 .48.11.92.18 1.36H0v14h2v2h20v-2h2V6h-4zM8 8h8v12H8V8z"/></svg>
    </div>
    <div>
      <p class="text-xs text-gray-500 font-medium">Total Barang</p>
      <p class="text-2xl font-bold text-gray-900">{{ $totalBarang }}</p>
      <p class="text-xs text-gray-400">Jenis barang aktif</p>
    </div>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
    <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
    </div>
    <div>
      <p class="text-xs text-gray-500 font-medium">Total Masuk</p>
      <p class="text-2xl font-bold text-gray-900">{{ $totalMasuk }}</p>
      <p class="text-xs text-gray-400">Qty semua transaksi masuk</p>
    </div>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
    <div class="w-11 h-11 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13H5v-2h14v2z"/></svg>
    </div>
    <div>
      <p class="text-xs text-gray-500 font-medium">Total Keluar</p>
      <p class="text-2xl font-bold text-gray-900">{{ $totalKeluar }}</p>
      <p class="text-xs text-gray-400">Qty semua transaksi keluar</p>
    </div>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
    <div class="w-11 h-11 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
    </div>
    <div>
      <p class="text-xs text-gray-500 font-medium">Stok Rendah</p>
      <p class="text-2xl font-bold text-gray-900">{{ $stokRendah }}</p>
      <p class="text-xs text-gray-400">Perlu restok segera</p>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mb-6">
  <div class="bg-white rounded-xl border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100">
      <h2 class="text-sm font-semibold text-gray-800">Stok Per Kategori</h2>
    </div>
    <div class="p-5 space-y-3">
      @php $maxStock = $categories->max('total_stock') ?: 1; @endphp
      @foreach($categories as $cat)
      <div class="flex items-center gap-3">
        <span class="text-xs text-gray-600 w-36 flex-shrink-0">{{ $cat->name }}</span>
        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
          <div class="h-full bg-blue-500 rounded-full" style="width:{{ round(($cat->total_stock/$maxStock)*100) }}%"></div>
        </div>
        <span class="text-xs font-semibold text-gray-700 w-8 text-right">{{ $cat->total_stock ?? 0 }}</span>
      </div>
      @endforeach
    </div>
  </div>

  <div class="bg-white rounded-xl border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100">
      <h2 class="text-sm font-semibold text-gray-800">Barang Stok Rendah</h2>
    </div>
    <table class="w-full text-sm">
      <thead><tr class="bg-gray-50 text-xs text-gray-500 uppercase">
        <th class="px-4 py-2.5 text-left">Nama Barang</th>
        <th class="px-4 py-2.5 text-left">Stok</th>
        <th class="px-4 py-2.5 text-left">Min</th>
        <th class="px-4 py-2.5 text-left">Status</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($lowStockItems as $item)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-2.5 text-gray-700">{{ $item->name }}</td>
          <td class="px-4 py-2.5 font-semibold text-red-600">{{ $item->stock }}</td>
          <td class="px-4 py-2.5 text-gray-500">{{ $item->min_stock }}</td>
          <td class="px-4 py-2.5"><span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded-full">Perlu Restok</span></td>
        </tr>
        @empty
        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">✓ Semua stok aman</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="bg-white rounded-xl border border-gray-200">
  <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
    <h2 class="text-sm font-semibold text-gray-800">Transaksi Terbaru</h2>
    <a href="{{ route('transaksi.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead><tr class="bg-gray-50 text-xs text-gray-500 uppercase">
        <th class="px-4 py-2.5 text-left">Tanggal</th>
        <th class="px-4 py-2.5 text-left">Barang</th>
        <th class="px-4 py-2.5 text-left">Tipe</th>
        <th class="px-4 py-2.5 text-left">Qty</th>
        <th class="px-4 py-2.5 text-left">Sumber</th>
        <th class="px-4 py-2.5 text-left">Operator</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($recentTransactions as $tx)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-2.5 text-gray-500">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
          <td class="px-4 py-2.5 font-medium text-gray-800">{{ $tx->item->name ?? '-' }}</td>
          <td class="px-4 py-2.5">
            @if($tx->transaction_type === 'in')
              <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Masuk</span>
            @else
              <span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded-full">Keluar</span>
            @endif
          </td>
          <td class="px-4 py-2.5 font-semibold {{ $tx->transaction_type==='in' ? 'text-green-600' : 'text-red-600' }}">
            {{ $tx->transaction_type==='in' ? '+' : '−' }}{{ $tx->qty }}
          </td>
          <td class="px-4 py-2.5 text-gray-500">{{ $tx->source ?? '-' }}</td>
          <td class="px-4 py-2.5 text-gray-500">{{ $tx->creator->name ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada transaksi</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection