@extends('layouts.app')
@section('title', 'Master Data')
@section('page-title', 'Master Data — Kategori & Unit')

@section('content')

{{-- ===== BARIS ATAS: Form Tambah ===== --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mb-5">

    {{-- Form Tambah Kategori --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-1 h-5 rounded-full" style="background:#f5c518"></div>
            <h2 class="text-sm font-bold text-gray-800">Tambah Kategori</h2>
        </div>
        <form action="{{ route('master-data.kategori.store') }}" method="POST" class="flex gap-3">
            @csrf
            <div class="flex-1">
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Contoh: Elektronik, ATK, Furnitur..."
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none
                           focus:border-yellow-400 focus:ring-2 focus:ring-yellow-50">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                    class="flex items-center gap-1.5 text-white text-sm font-semibold px-4 py-2.5 rounded-lg
                           whitespace-nowrap hover:opacity-90 transition-opacity"
                    style="background:#1e3a5f">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Tambah
            </button>
        </form>
    </div>

    {{-- Form Tambah Unit --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-1 h-5 rounded-full" style="background:#1a7a4a"></div>
            <h2 class="text-sm font-bold text-gray-800">Tambah Unit</h2>
        </div>
        <form action="{{ route('master-data.unit.store') }}" method="POST" class="flex gap-3">
            @csrf
            <div class="flex-1">
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Contoh: Pcs, Buah, Set, Rim, Botol..."
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none
                           focus:border-green-400 focus:ring-2 focus:ring-green-50">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                    class="flex items-center gap-1.5 text-white text-sm font-semibold px-4 py-2.5 rounded-lg
                           whitespace-nowrap hover:opacity-90 transition-opacity"
                    style="background:#1a7a4a">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Tambah
            </button>
        </form>
    </div>

</div>

{{-- ===== BARIS BAWAH: Tabel Data ===== --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

    {{-- Tabel Kategori --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-1 h-5 rounded-full" style="background:#f5c518"></div>
                <h3 class="text-sm font-bold text-gray-800">Daftar Kategori</h3>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                  style="background:#e8eef5; color:#1e3a5f">
                {{ $categories->count() }} kategori
            </span>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs font-semibold text-white uppercase"
                    style="background: linear-gradient(90deg, #1e3a5f, #2a4f80)">
                    <th class="px-4 py-3 text-left">Nama Kategori</th>
                    <th class="px-4 py-3 text-center">Jumlah Barang</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $cat)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 font-medium text-gray-800">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full" style="background:#f5c518"></div>
                            {{ $cat->name }}
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($cat->items_count > 0)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                                  style="background:#e8eef5; color:#1e3a5f">
                                {{ $cat->items_count }} barang
                            </span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($cat->items_count == 0)
                            <form action="{{ route('master-data.kategori.destroy', $cat) }}" method="POST"
                                  onsubmit="return confirm('Hapus kategori \'{{ $cat->name }}\'?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs bg-red-50 hover:bg-red-100 text-red-600
                                               px-3 py-1.5 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400" title="Tidak bisa dihapus, masih digunakan">
                                Digunakan
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-10 text-center text-gray-400">
                        Belum ada kategori. Tambahkan di atas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Tabel Unit --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-1 h-5 rounded-full" style="background:#1a7a4a"></div>
                <h3 class="text-sm font-bold text-gray-800">Daftar Unit</h3>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                  style="background:#e6f5ed; color:#145c37">
                {{ $units->count() }} unit
            </span>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs font-semibold text-white uppercase"
                    style="background: linear-gradient(90deg, #1a7a4a, #22a060)">
                    <th class="px-4 py-3 text-left">Nama Unit</th>
                    <th class="px-4 py-3 text-center">Jumlah Barang</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($units as $unit)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 font-medium text-gray-800">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full" style="background:#1a7a4a"></div>
                            {{ $unit->name }}
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($unit->items_count > 0)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                                  style="background:#e6f5ed; color:#145c37">
                                {{ $unit->items_count }} barang
                            </span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($unit->items_count == 0)
                            <form action="{{ route('master-data.unit.destroy', $unit) }}" method="POST"
                                  onsubmit="return confirm('Hapus unit \'{{ $unit->name }}\'?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs bg-red-50 hover:bg-red-100 text-red-600
                                               px-3 py-1.5 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400" title="Tidak bisa dihapus, masih digunakan">
                                Digunakan
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-10 text-center text-gray-400">
                        Belum ada unit. Tambahkan di atas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
