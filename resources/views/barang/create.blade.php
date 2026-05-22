@extends('layouts.app')
@section('title','Tambah Barang')
@section('page-title','Tambah Barang')

@section('content')
<div class="max-w-2xl">
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <form action="{{ route('barang.store') }}" method="POST" class="space-y-4">
      @csrf

      {{-- Kode otomatis (readonly, preview berubah saat pilih kategori) --}}
      <div class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 flex items-center gap-3">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
          <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-5 11.5v-3h-2v3H9l4 4 4-4h-2zm-4-7V5.5l-4 4h2v3h2V9.5h2l-4-4v3z"/>
        </svg>
        <div>
          <p class="text-xs text-slate-500">Kode barang — otomatis berdasarkan kategori</p>
          <p id="previewKode" class="text-sm font-bold font-mono" style="color:#1e3a5f">
            Pilih kategori dulu...
          </p>
        </div>
      </div>

      {{-- Nama Barang --}}
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Barang *</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama barang"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      {{-- Kategori & Unit --}}
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Kategori *</label>
          <select name="category_id" id="categorySelect"
                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Unit *</label>
          <select name="unit_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
            <option value="">-- Pilih Unit --</option>
            @foreach($units as $unit)
              <option value="{{ $unit->id }}" {{ old('unit_id')==$unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
            @endforeach
          </select>
          @error('unit_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Stok Awal & Min Stok --}}
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Stok Awal</label>
          <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Min Stok
            <span class="text-gray-400 font-normal normal-case">(opsional, untuk peringatan)</span>
          </label>
          <input type="number" name="min_stock" value="{{ old('min_stock', 0) }}" min="0"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>
      </div>

      {{-- Lokasi --}}
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Lokasi</label>
        <input type="text" name="location" value="{{ old('location') }}" placeholder="Gudang A / Rak 1"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
      </div>

      <div class="flex gap-3 pt-2">
        <a href="{{ route('barang.index') }}" class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
        <button type="submit" class="flex-1 text-white text-sm font-medium px-4 py-2.5 rounded-lg" style="background:#1e3a5f">
          Simpan Barang
        </button>
      </div>
    </form>
  </div>
</div>

<script>
const categorySelect = document.getElementById('categorySelect');
const previewKode    = document.getElementById('previewKode');

function updatePreviewKode(categoryId) {
    if (!categoryId) {
        previewKode.textContent = 'Pilih kategori dulu...';
        previewKode.style.color = '#94a3b8';
        return;
    }
    previewKode.textContent = 'Memuat...';
    fetch(`{{ url('/barang/preview-kode') }}/${categoryId}`)
        .then(r => r.json())
        .then(data => {
            previewKode.textContent = data.code;
            previewKode.style.color = '#1e3a5f';
        });
}

categorySelect.addEventListener('change', function () {
    updatePreviewKode(this.value);
});

// Jika ada old value (validasi gagal)
if (categorySelect.value) updatePreviewKode(categorySelect.value);
</script>
@endsection
