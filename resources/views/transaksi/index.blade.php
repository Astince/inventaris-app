@extends('layouts.app')
@section('title', 'Transaksi Barang')
@section('page-title', 'Transaksi Barang')

@section('content')

{{-- Tombol aksi utama --}}
<div class="flex flex-wrap gap-3 mb-5">
    <a href="{{ route('transaksi.create', ['type' => 'in']) }}"
       class="inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm hover:opacity-90 transition-opacity"
       style="background:#1a7a4a">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
        </svg>
        Barang Masuk
    </a>
    <a href="{{ route('transaksi.create', ['type' => 'out']) }}"
       class="inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm hover:opacity-90 transition-opacity bg-red-600">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 13H5v-2h14v2z"/>
        </svg>
        Barang Keluar
    </a>
    <a href="{{ route('riwayat.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-50 transition-colors">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
        </svg>
        Lihat Riwayat
    </a>
</div>

{{-- Tabel transaksi terbaru --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
        <div class="w-1 h-5 rounded-full" style="background:#1a7a4a"></div>
        <h2 class="text-sm font-bold text-gray-800">Transaksi Terbaru</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs font-bold text-white uppercase"
                    style="background: linear-gradient(90deg, #1e3a5f, #2a4f80)">
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Kode</th>
                    <th class="px-4 py-3 text-left">Nama Barang</th>
                    <th class="px-4 py-3 text-center">Tipe</th>
                    <th class="px-4 py-3 text-center">Qty</th>
                    <th class="px-4 py-3 text-left">Sumber</th>
                    <th class="px-4 py-3 text-left">Operator</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $tx)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500 text-xs">
                        {{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-mono text-xs px-2 py-0.5 rounded font-semibold"
                              style="background:#e8eef5; color:#1e3a5f">
                            {{ $tx->item->code ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $tx->item->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($tx->transaction_type === 'in')
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                                  style="background:#e6f5ed; color:#145c37">↑ Masuk</span>
                        @else
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-700">
                                ↓ Keluar
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center font-bold
                               {{ $tx->transaction_type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $tx->transaction_type === 'in' ? '+' : '−' }}{{ $tx->qty }}
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $tx->source ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $tx->creator->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                        Belum ada transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">{{ $transactions->links() }}</div>
    @endif
</div>

@endsection
