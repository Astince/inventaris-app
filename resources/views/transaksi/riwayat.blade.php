@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')

{{-- Filter --}}
<form method="GET" action="{{ route('riwayat.index') }}"
      class="bg-white rounded-xl border border-gray-200 p-4 mb-5">
    <div class="flex flex-wrap gap-3 items-end">

        {{-- Cari barang --}}
        <div class="flex-1 min-w-40">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Cari Barang</label>
            <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nama / kode barang..."
                       class="outline-none text-sm w-full bg-transparent">
            </div>
        </div>

        {{-- Filter tipe --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tipe</label>
            <select name="type" class="border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none">
                <option value="">Semua</option>
                <option value="in"  {{ request('type') === 'in'  ? 'selected' : '' }}>Masuk</option>
                <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>

        {{-- Dari tanggal --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Dari</label>
            <input type="date" name="from" value="{{ request('from') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none">
        </div>

        {{-- Sampai tanggal --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Sampai</label>
            <input type="date" name="to" value="{{ request('to') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none">
        </div>

        {{-- Tombol --}}
        <div class="flex gap-2">
            <button type="submit"
                    class="text-white text-sm font-semibold px-4 py-2 rounded-lg hover:opacity-90"
                    style="background:#1e3a5f">
                Filter
            </button>
            @if(request('search') || request('type') || request('from') || request('to'))
                <a href="{{ route('riwayat.index') }}"
                   class="text-sm text-gray-500 border border-gray-200 px-4 py-2 rounded-lg hover:bg-gray-50">
                    Reset
                </a>
            @endif
        </div>

    </div>
</form>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-1 h-5 rounded-full" style="background:#1e3a5f"></div>
            <h2 class="text-sm font-bold text-gray-800">Semua Riwayat Transaksi</h2>
        </div>
        <span class="text-xs text-gray-400">{{ $transactions->total() }} transaksi</span>
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
                    <th class="px-4 py-3 text-center">Stok Sebelum</th>
                    <th class="px-4 py-3 text-center">Stok Sesudah</th>
                    <th class="px-4 py-3 text-left">Sumber</th>
                    <th class="px-4 py-3 text-left">Catatan</th>
                    <th class="px-4 py-3 text-left">Operator</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $tx)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
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
                    <td class="px-4 py-3 text-center text-gray-500">{{ $tx->stock_before }}</td>
                    <td class="px-4 py-3 text-center font-semibold" style="color:#1e3a5f">
                        {{ $tx->stock_after }}
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $tx->source ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-400 text-xs max-w-32 truncate"
                        title="{{ $tx->note }}">
                        {{ $tx->note ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $tx->creator->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-12 text-center text-gray-400">
                        Tidak ada riwayat transaksi.
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
