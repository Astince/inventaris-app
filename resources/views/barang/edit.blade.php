@extends('layouts.app')
@section('title','Edit Barang')
@section('page-title','Edit Barang')

@section('content')
<div class="max-w-2xl">
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <form action="{{ route('barang.update', $barang) }}" method="POST" class="space-y-4">
      @csrf @method('PUT')

      {{-- Kode (readonly) --}}
      <div class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 flex items-center gap-3">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
          <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-5 11.5v-3h-2v3H9l4 4 4-4h-2zm-4-7V5.5l-4 4h2v3h2V9.5h2l-4-4v3z"/>
        </svg>
        <div>
          <p class="text-xs text-slate-500">Kode Barang</p>
          <p class="text-sm font-bold font-mono" style="color:#1e3a5f">{{ $barang->code }}</p>
        </div>
      </div>

      {{-- Nama Barang --}}
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Barang *</label>
        <input type="text" name="name" value="{{ old('name', $barang->name) }}"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Kategori & Unit --}}
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

      {{-- Min Stok & Lokasi --}}
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Min Stok
            <span class="text-gray-400 font-normal normal-case">(opsional)</span>
          </label>
          <input type="number" name="min_stock" value="{{ old('min_stock', $barang->min_stock) }}" min="0"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Lokasi</label>
          <input type="text" name="location" value="{{ old('location', $barang->location) }}"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>
      </div>

      <div class="flex gap-3 pt-2">
        <a href="{{ route('barang.index') }}" class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
        <button type="submit" class="flex-1 text-white text-sm font-medium px-4 py-2.5 rounded-lg" style="background:#1e3a5f">
          Update Barang
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
