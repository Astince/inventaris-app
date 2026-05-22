@extends('layouts.app')
@section('title','Master Barang')
@section('page-title','Master Barang')

@section('content')
<div class="flex flex-wrap items-center gap-3 mb-5">
  <form method="GET" action="{{ route('barang.index') }}" class="flex gap-2 flex-1 flex-wrap">
    <div class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-3 py-2 flex-1 max-w-xs">
      <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." class="outline-none text-sm w-full bg-transparent">
    </div>
    <select name="category_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white outline-none">
      <option value="">Semua Kategori</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
      @endforeach
    </select>
    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-lg">Filter</button>
    @if(request('search') || request('category_id'))
      <a href="{{ route('barang.index') }}" class="text-sm text-gray-500 px-3 py-2">Reset</a>
    @endif
  </form>
  <a href="{{ route('barang.create') }}" class="flex items-center gap-2 text-white text-sm font-medium px-4 py-2 rounded-lg" style="background:#1e3a5f">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
    Tambah Barang
  </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-xs font-bold text-white uppercase" style="background: linear-gradient(90deg, #1e3a5f, #2a4f80)">
          <th class="px-4 py-3 text-left">Kode</th>
          <th class="px-4 py-3 text-left">Nama Barang</th>
          <th class="px-4 py-3 text-left">Kategori</th>
          <th class="px-4 py-3 text-left">Unit</th>
          <th class="px-4 py-3 text-center">Stok</th>
          <th class="px-4 py-3 text-center">Min Stok</th>
          <th class="px-4 py-3 text-left">Lokasi</th>
          <th class="px-4 py-3 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($items as $item)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3">
            <span class="font-mono text-xs px-2 py-0.5 rounded font-semibold" style="background:#e8eef5; color:#1e3a5f">
              {{ $item->code }}
            </span>
          </td>
          <td class="px-4 py-3 font-medium text-gray-800">{{ $item->name }}</td>
          <td class="px-4 py-3 text-gray-600">{{ $item->category->name ?? '-' }}</td>
          <td class="px-4 py-3 text-gray-600">{{ $item->unit->name ?? '-' }}</td>
          <td class="px-4 py-3 text-center font-bold {{ $item->isLowStock() ? 'text-red-600' : '' }}"
              style="{{ !$item->isLowStock() ? 'color:#1e3a5f' : '' }}">
            {{ $item->stock }}
            @if($item->isLowStock())
              <span class="block text-xs font-normal text-red-500">⚠ Rendah</span>
            @endif
          </td>
          <td class="px-4 py-3 text-center text-gray-500">{{ $item->min_stock }}</td>
          <td class="px-4 py-3 text-gray-500">{{ $item->location ?? '-' }}</td>
          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              <a href="{{ route('barang.edit', $item) }}"
                 class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg">Edit</a>
              <form action="{{ route('barang.destroy', $item) }}" method="POST"
                    onsubmit="return confirm('Hapus barang {{ $item->name }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="px-4 py-12 text-center text-gray-400">Tidak ada data barang.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($items->hasPages())
  <div class="px-4 py-3 border-t border-gray-100">{{ $items->links() }}</div>
  @endif
</div>
@endsection
