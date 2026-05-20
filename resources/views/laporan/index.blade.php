@extends('layouts.app')
@section('title','Laporan Stok')
@section('page-title','Laporan Stok')
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead><tr class="bg-gray-50 text-xs text-gray-500 uppercase">
        <th class="px-4 py-3 text-left">Kode</th>
        <th class="px-4 py-3 text-left">Nama Barang</th>
        <th class="px-4 py-3 text-left">Kategori</th>
        <th class="px-4 py-3 text-left">Unit</th>
        <th class="px-4 py-3 text-left">Stok</th>
        <th class="px-4 py-3 text-left">Min</th>
        <th class="px-4 py-3 text-left">Total Masuk</th>
        <th class="px-4 py-3 text-left">Total Keluar</th>
        <th class="px-4 py-3 text-left">Status</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($items as $item)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3"><span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded text-blue-700">{{ $item->code }}</span></td>
          <td class="px-4 py-3 font-medium text-gray-800">{{ $item->name }}</td>
          <td class="px-4 py-3 text-gray-600">{{ $item->category->name ?? '-' }}</td>
          <td class="px-4 py-3 text-gray-600">{{ $item->unit->name ?? '-' }}</td>
          <td class="px-4 py-3 font-semibold {{ $item->isLowStock() ? 'text-red-600' : 'text-gray-800' }}">{{ $item->stock }}</td>
          <td class="px-4 py-3 text-gray-500">{{ $item->min_stock }}</td>
          <td class="px-4 py-3 text-green-600 font-semibold">+{{ $item->total_masuk }}</td>
          <td class="px-4 py-3 text-red-600 font-semibold">-{{ $item->total_keluar }}</td>
          <td class="px-4 py-3">
            @if($item->isLowStock())
              <span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded-full">Perlu Restok</span>
            @else
              <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Aman</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="9" class="px-4 py-12 text-center text-gray-400">Tidak ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection