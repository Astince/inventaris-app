@extends('layouts.app')
@section('title','Edit Barang')
@section('page-title','Edit Barang')

@section('content')
<div class="max-w-2xl">
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <form action="{{ route('barang.update', $barang) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kode Barang *</label>
          <input type="text" name="code" value="{{ old('code',$barang->code) }}"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
          @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Barang *</label>
          <input type="text" name="name" value="{{ old('name',$barang->name) }}"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
          @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kategori *</label>
          <select name="category_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ $barang->category_id==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Unit *</label>
          <select name="unit_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
            @foreach($units as $unit)
              <option value="{{ $unit->id }}" {{ $barang->unit_id==$unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Min Stok *</label>
          <input type="number" name="min_stock" value="{{ old('min_stock',$barang->min_stock) }}" min="0"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Lokasi</label>
          <input type="text" name="location" value="{{ old('location',$barang->location) }}"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status</label>
        <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
          <option value="active" {{ $barang->status==='active' ? 'selected' : '' }}>Aktif</option>
          <option value="inactive" {{ $barang->status==='inactive' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
      </div>
      <div class="flex gap-3 pt-2">
        <a href="{{ route('barang.index') }}" class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg">Update Barang</button>
      </div>
    </form>
  </div>
</div>
@endsection