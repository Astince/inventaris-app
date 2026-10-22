@extends('layouts.app')
@section('title', 'Input Transaksi')
@section('page-title', 'Input Transaksi')

@section('content')
<div class="max-w-xl mx-auto">
  <div class="bg-white rounded-xl border border-gray-200 p-6">

    {{-- Tab pilih tipe transaksi --}}
    <div class="flex rounded-lg overflow-hidden border border-gray-200 mb-5">
      <button type="button" id="tabIn" onclick="setTxType('in')"
         class="flex-1 text-center text-sm font-semibold py-2.5 transition-colors focus:outline-none">
        ↑ Barang Masuk
      </button>
      <button type="button" id="tabOut" onclick="setTxType('out')"
         class="flex-1 text-center text-sm font-semibold py-2.5 transition-colors border-l border-gray-200 focus:outline-none">
        ↓ Barang Keluar
      </button>
    </div>

    <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" id="transaction_type" name="transaction_type" value="{{ old('transaction_type', $type) }}">

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
          <div class="relative flex items-center">
            <input type="number" name="qty" value="{{ old('qty', 1) }}" min="1"
              class="w-full border border-gray-200 rounded-lg pl-3 pr-16 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
            <span id="qtyUnitBadge" class="absolute right-3 text-xs font-semibold text-gray-400">
              unit
            </span>
          </div>
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
        <label id="sourceLabel" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
          Sumber / Asal Barang
        </label>
        <input type="text" id="sourceInput" name="source" value="{{ old('source') }}"
          placeholder="Supplier / Pengadaan"
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
        <button type="submit" id="submitBtn"
                class="flex-1 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition-colors">
          Simpan Transaksi
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function setTxType(type) {
    const hiddenInput = document.getElementById('transaction_type');
    hiddenInput.value = type;

    const tabIn = document.getElementById('tabIn');
    const tabOut = document.getElementById('tabOut');
    const sourceLabel = document.getElementById('sourceLabel');
    const sourceInput = document.getElementById('sourceInput');
    const submitBtn = document.getElementById('submitBtn');

    if (type === 'in') {
        // Active tab: In
        tabIn.className = "flex-1 text-center text-sm font-semibold py-2.5 transition-colors text-white focus:outline-none";
        tabIn.style.backgroundColor = "#1a7a4a";
        
        tabOut.className = "flex-1 text-center text-sm font-semibold py-2.5 transition-colors text-gray-500 hover:bg-gray-50 border-l border-gray-200 focus:outline-none";
        tabOut.style.backgroundColor = "";

        // Update Labels & Placeholders
        if (sourceLabel) sourceLabel.textContent = "Sumber / Asal Barang";
        if (sourceInput) sourceInput.placeholder = "Supplier / Pengadaan";

        // Update Submit Button
        if (submitBtn) {
            submitBtn.textContent = "Simpan Barang Masuk";
            submitBtn.style.backgroundColor = "#1a7a4a";
        }
    } else {
        // Active tab: Out
        tabOut.className = "flex-1 text-center text-sm font-semibold py-2.5 transition-colors text-white focus:outline-none";
        tabOut.style.backgroundColor = "#dc2626"; // red-600

        tabIn.className = "flex-1 text-center text-sm font-semibold py-2.5 transition-colors text-gray-500 hover:bg-gray-50 focus:outline-none";
        tabIn.style.backgroundColor = "";

        // Update Labels & Placeholders
        if (sourceLabel) sourceLabel.textContent = "Diserahkan Kepada";
        if (sourceInput) sourceInput.placeholder = "Nama penerima / departemen";

        // Update Submit Button
        if (submitBtn) {
            submitBtn.textContent = "Simpan Barang Keluar";
            submitBtn.style.backgroundColor = "#dc2626";
        }
    }
}

function updateInfo(sel) {
    const opt   = sel.options[sel.selectedIndex];
    const box   = document.getElementById('itemInfo');
    const badge = document.getElementById('qtyUnitBadge');
    if (!sel.value) {
        box.classList.add('hidden');
        if (badge) badge.textContent = 'unit';
        return;
    }
    document.getElementById('infoStok').textContent     = opt.dataset.stok;
    document.getElementById('infoUnit').textContent     = opt.dataset.unit;
    document.getElementById('infoKategori').textContent = opt.dataset.kategori;
    box.classList.remove('hidden');

    if (badge) {
        badge.textContent = opt.dataset.unit || 'unit';
    }
}

// Restore info & tab state jika ada old value atau default
window.addEventListener('DOMContentLoaded', () => {
    const sel = document.querySelector('select[name="item_id"]');
    if (sel && sel.value) updateInfo(sel);
    
    const initialType = "{{ old('transaction_type', $type) }}";
    setTxType(initialType);
});
</script>
@endsection
