@extends('layouts.app')
@section('title', 'Transaksi Barang')
@section('page-title', 'Transaksi Barang')

@section('content')

{{-- Tombol aksi utama --}}
<div class="flex flex-wrap gap-3 mb-5">
    <a href="{{ route('transaksi.create') }}"
       class="inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm hover:opacity-90 transition-opacity"
       style="background: linear-gradient(90deg, #1e3a5f, #2a4f80)">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Input Transaksi
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
                        <span class="text-xs font-normal text-gray-400 ml-0.5">{{ $tx->item->unit->name ?? '' }}</span>
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
