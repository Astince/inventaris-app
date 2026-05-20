@extends('layouts.app')
@section('title','Transaksi Barang')
@section('page-title','Transaksi Barang')

@section('content')
<div class="flex justify-end gap-3 mb-5">
  <a href="{{ route('transaksi.create',['type'=>'in']) }}" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
    Barang Masuk
  </a>
  <a href="{{ route('transaksi.create',['type'=>'out']) }}" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg">
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13H5v-2h14v2z"/></svg>
    Barang Keluar
  </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead><tr class="bg-gray-50 text-xs text-gray-500 uppercase">
        <th class="px-4 py-3 text-left">Tanggal</th>
        <th class="px-4 py-3 text-left">Kode</th>
        <th class="px-4 py-3 text-left">Nama Barang</th>
        <th class="px-4 py-3 text-left">Tipe</th>
        <th class="px-4 py-3 text-left">Qty</th>
        <th class="px-4 py-3 text-left">Sumber</th>
        <th class="px-4 py-3 text-left">Operator</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($transactions as $tx)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3 text-gray-500">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
          <td class="px-4 py-3"><span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded text-blue-700">{{ $tx->item->code ?? '-' }}</span></td>
          <td class="px-4 py-3 font-medium text-gray-800">{{ $tx->item->name ?? '-' }}</td>
          <td class="px-4 py-3">
            @if($tx->transaction_type==='in')
              <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Masuk</span>
            @else
              <span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded-full">Keluar</span>
            @endif
          </td>
          <td class="px-4 py-3 font-semibold {{ $tx->transaction_type==='in' ? 'text-green-600' : 'text-red-600' }}">
            {{ $tx->transaction_type==='in' ? '+' : '−' }}{{ $tx->qty }}
          </td>
          <td class="px-4 py-3 text-gray-500">{{ $tx->source ?? '-' }}</td>
          <td class="px-4 py-3 text-gray-500">{{ $tx->creator->name ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">Belum ada transaksi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($transactions->hasPages())
  <div class="px-4 py-3 border-t border-gray-100">{{ $transactions->links() }}</div>
  @endif
</div>
@endsection