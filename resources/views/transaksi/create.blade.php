@extends('layouts.app')
@section('title', $type==='in' ? 'Barang Masuk' : 'Barang Keluar')
@section('page-title', $type==='in' ? 'Input Barang Masuk' : 'Input Barang Keluar')

@section('content')
<div class="max-w-xl">
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="hidden" name="transaction_type" value="{{ $type }}">
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Barang *</label>
        <select name="item_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400" onchange="updateStok(this)">
          <option value="">-- Pilih Barang --</option>
          @foreach($items as $item)
            <option value="{{ $item->id }}" data-stok="{{ $item->stock }}" data-unit="{{ $item->unit->name ?? '' }}">
              {{ $item->code }} - {{ $item->name }} (Stok: {{ $item->stock }})
            </option>
          @endforeach
        </select>
        @error('item_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        <div id="stokInfo" class="mt-2 text-xs text-gray-500 bg-gray-50 px-3 py-2 rounded-lg hidden"></div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jumlah (Qty) *</label>
          <input type="number" name="qty" value="{{ old('qty',1) }}" min="1"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
          @error('qty')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal *</label>
          <input type="date" name="date" value="{{ old('date',date('Y-m-d')) }}"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Sumber / Asal</label>
        <input type="text" name="source" value="{{ old('source') }}" placeholder="Supplier / Departemen"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Catatan</label>
        <textarea name="note" rows="3" placeholder="Catatan tambahan..."
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">{{ old('note') }}</textarea>
      </div>
      <div class="flex gap-3 pt-2">
        <a href="{{ route('transaksi.index') }}" class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
        <button type="submit" class="flex-1 {{ $type==='in' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white text-sm font-medium px-4 py-2.5 rounded-lg">
          Simpan {{ $type==='in' ? 'Barang Masuk' : 'Barang Keluar' }}
        </button>
      </div>
    </form>
  </div>
</div>
<script>
function updateStok(sel) {
  const opt = sel.options[sel.selectedIndex];
  const info = document.getElementById('stokInfo');
  if (sel.value) {
    info.textContent = 'Stok saat ini: ' + opt.dataset.stok + ' ' + opt.dataset.unit;
    info.classList.remove('hidden');
  } else { info.classList.add('hidden'); }
}
</script>
@endsection