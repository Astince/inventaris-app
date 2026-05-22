@extends('layouts.app')
@section('title','Kelola Akun')
@section('page-title','Kelola Akun')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

  {{-- ===== DAFTAR AKUN ===== --}}
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
      <div class="w-1 h-5 rounded-full" style="background:#f5c518"></div>
      <h2 class="text-sm font-bold text-gray-800">Daftar Akun Pengguna</h2>
    </div>
    <table class="w-full text-sm">
      <thead>
        <tr class="text-xs text-gray-500 uppercase bg-gray-50">
          <th class="px-4 py-3 text-left">Nama</th>
          <th class="px-4 py-3 text-left">Email</th>
          <th class="px-4 py-3 text-left">Role</th>
          <th class="px-4 py-3 text-center">Status</th>
          <th class="px-4 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($users as $user)
        <tr class="hover:bg-gray-50 {{ !$user->is_active ? 'opacity-60' : '' }}">
          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              {{-- Avatar inisial --}}
              <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                   style="background: {{ $user->is_active ? '#1e3a5f' : '#9ca3af' }}">
                {{ strtoupper(substr($user->name, 0, 2)) }}
              </div>
              <span class="font-medium text-gray-800">{{ $user->name }}</span>
              @if($user->id === auth()->id())
                <span class="text-xs text-blue-500 font-medium">(Anda)</span>
              @endif
            </div>
          </td>
          <td class="px-4 py-3 text-gray-500 text-xs">{{ $user->email }}</td>
          <td class="px-4 py-3">
            @if($user->role === 'superadmin')
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#e8eef5; color:#1e3a5f">
                Super Admin
              </span>
            @else
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                Operator
              </span>
            @endif
          </td>
          <td class="px-4 py-3 text-center">
            @if($user->is_active)
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#e6f5ed; color:#145c37">
                Aktif
              </span>
            @else
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-50 text-red-600">
                Nonaktif
              </span>
            @endif
          </td>
          <td class="px-4 py-3">
            @if($user->id !== auth()->id())
            <div class="flex flex-col gap-1.5">
              {{-- Toggle aktif/nonaktif --}}
              <form action="{{ route('users.toggle', $user) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit"
                        class="w-full text-xs px-3 py-1.5 rounded-lg font-medium transition-colors
                               {{ $user->is_active
                                  ? 'bg-yellow-50 hover:bg-yellow-100 text-yellow-700'
                                  : 'bg-green-50 hover:bg-green-100 text-green-700' }}">
                  {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
              </form>
              {{-- Hapus --}}
              <form action="{{ route('users.destroy', $user) }}" method="POST"
                    onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-full text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg">
                  Hapus
                </button>
              </form>
            </div>
            @else
              <span class="text-xs text-gray-400">—</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada akun.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- ===== FORM TAMBAH AKUN ===== --}}
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center gap-2 mb-5">
      <div class="w-1 h-5 rounded-full" style="background:#1a7a4a"></div>
      <h2 class="text-sm font-bold text-gray-800">Buat Akun Baru</h2>
    </div>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama pengguna"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email *</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@kantor.com"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Password *</label>
        <input type="password" name="password" placeholder="Min. 6 karakter"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Role *</label>
          <select name="role" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
            <option value="operator" {{ old('role')=='operator' ? 'selected' : '' }}>Operator</option>
            <option value="superadmin" {{ old('role')=='superadmin' ? 'selected' : '' }}>Super Admin</option>
          </select>
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status Akun</label>
          <select name="is_active" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
            <option value="1">Aktif</option>
            <option value="0">Nonaktif (Sementara)</option>
          </select>
        </div>
      </div>

      <button type="submit"
              class="w-full text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-opacity hover:opacity-90"
              style="background:#1e3a5f">
        Buat Akun
      </button>
    </form>
  </div>

</div>
@endsection
