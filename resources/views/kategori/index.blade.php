@extends('layouts.app')
@section('title','Kategori Barang')
@section('page-title','Kategori Barang')
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
      <thead><tr class="bg-gray-50 text-xs text-gray-500 uppercase">
        <th class="px-4 py-3 text-left">Nama Kategori</th>
        <th class="px-4 py-3 text-left">Jumlah Barang</th>
        <th class="px-4 py-3 text-left">Aksi</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($categories as $cat)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3 font-medium text-gray-800">{{ $cat->name }}</td>
          <td class="px-4 py-3 text-gray-600">{{ $cat->items_count }}</td>
          <td class="px-4 py-3">
            <form action="{{ route('kategori.destroy',$cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
              @csrf @method('DELETE')
              <button class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="3" class="px-4 py-8 text-center text-gray-400">Belum ada kategori.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="text-sm font-semibold text-gray-800 mb-4">Tambah Kategori</h2>
    <form action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
        <input type="text" name="name" placeholder="Elektronik / ATK / Furnitur"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg">Simpan</button>
    </form>
  </div>
</div>
@endsection