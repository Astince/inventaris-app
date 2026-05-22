@extends('layouts.app')
@section('title', $type==='in' ? 'Barang Masuk' : 'Barang Keluar')
@section('page-title', $type==='in' ? 'Input Barang Masuk' : 'Input Barang Keluar')

@section('content')
<div class="max-w-xl">
  <div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Tab pilih tipe transaksi --}}
    <div class="flex rounded-lg overflow-hidden border border-gray-200 mb-5">
      <a href="{{ route('transaksi.create', ['type'=>'in']) }}"
         class="flex-1 text-center text-sm font-semibold py-2.5 transition-colors
                {{ $type==='in' ? 'text-white' : 'text-gray-500 hover:bg-gray-50' }}"
         style="{{ $type==='in' ? 'background:#1a7a4a' : '' }}">
        ↑ Barang Masuk
      </a>
      <a href="{{ route('transaksi.create', ['type'=>'out']) }}"
         class="flex-1 text-center text-sm font-semibold py-2.5 transition-colors border-l border-gray-200
                {{ $type==='out' ? 'text-white bg-red-600' : 'text-gray-500 hover:bg-gray-50' }}">
        ↓ Barang Keluar
      </a>
    </div>

    <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" name="transaction_type" value="{{ $type }}">

      {{-- Pilih Barang --}}
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Barang *</label>
        <select name="item_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400"
                onchange="updateInfo(this)">
          <option value="">-- Pilih Barang --</option>
          @foreach($items as $item)
            <option value="{{ $item->id }}"
                    data-stok="{{ $item->stock }}"
                    data-unit="{{ $item->unit->name ?? '' }}"
                    data-kategori="{{ $item->category->name ?? '' }}"
                    {{ old('item_id')==$item->id ? 'selected' : '' }}>
              {{ $item->code }} — {{ $item->name }}
            </option>
          @endforeach
        </select>
        @error('item_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

        {{-- Info stok barang terpilih --}}
        <div id="itemInfo" class="mt-2 hidden">
          <div class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 flex items-center gap-4 text-xs text-slate-600">
            <span>Kategori: <strong id="infoKategori" class="text-slate-800"></strong></span>
            <span>Stok saat ini: <strong id="infoStok" class="text-slate-800"></strong></span>
            <span>Unit: <strong id="infoUnit" class="text-slate-800"></strong></span>
          </div>
        </div>
      </div>

      {{-- Qty & Tanggal --}}
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jumlah (Qty) *</label>
          <input type="number" name="qty" value="{{ old('qty', 1) }}" min="1"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
          @error('qty')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal *</label>
          <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>
      </div>

      {{-- Sumber / Asal --}}
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
          {{ $type==='in' ? 'Sumber / Asal Barang' : 'Diserahkan Kepada' }}
        </label>
        <input type="text" name="source" value="{{ old('source') }}"
          placeholder="{{ $type==='in' ? 'Supplier / Pengadaan' : 'Nama penerima / departemen' }}"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
      </div>

      {{-- Catatan --}}
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Catatan</label>
        <textarea name="note" rows="2" placeholder="Catatan tambahan (opsional)..."
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">{{ old('note') }}</textarea>
      </div>

      <div class="flex gap-3 pt-2">
        <a href="{{ route('transaksi.index') }}"
           class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50">
          Batal
        </a>
        <button type="submit"
                class="flex-1 text-white text-sm font-medium px-4 py-2.5 rounded-lg"
                style="background: {{ $type==='in' ? '#1a7a4a' : '#dc2626' }}">
          Simpan {{ $type==='in' ? 'Barang Masuk' : 'Barang Keluar' }}
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function updateInfo(sel) {
    const opt   = sel.options[sel.selectedIndex];
    const box   = document.getElementById('itemInfo');
    if (!sel.value) { box.classList.add('hidden'); return; }
    document.getElementById('infoStok').textContent     = opt.dataset.stok;
    document.getElementById('infoUnit').textContent     = opt.dataset.unit;
    document.getElementById('infoKategori').textContent = opt.dataset.kategori;
    box.classList.remove('hidden');
}
// Restore info jika ada old value
window.addEventListener('DOMContentLoaded', () => {
    const sel = document.querySelector('select[name="item_id"]');
    if (sel && sel.value) updateInfo(sel);
});
</script>
@endsection
