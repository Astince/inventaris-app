@extends('layouts.app')
@section('title','Kelola User')
@section('page-title','Kelola User')
@section('content')
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
      <thead><tr class="bg-gray-50 text-xs text-gray-500 uppercase">
        <th class="px-4 py-3 text-left">Nama</th>
        <th class="px-4 py-3 text-left">Email</th>
        <th class="px-4 py-3 text-left">Role</th>
        <th class="px-4 py-3 text-left">Aksi</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($users as $user)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
          <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
          <td class="px-4 py-3">
            @if($user->role==='superadmin')
              <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-0.5 rounded-full">Super Admin</span>
            @else
              <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded-full">Operator</span>
            @endif
          </td>
          <td class="px-4 py-3">
            @if($user->id !== auth()->id())
            <form action="{{ route('users.destroy',$user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
              @csrf @method('DELETE')
              <button class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg">Hapus</button>
            </form>
            @else
              <span class="text-xs text-gray-400">Akun Anda</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada user.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="text-sm font-semibold text-gray-800 mb-4">Tambah User</h2>
    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
        <input type="text" name="name" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email *</label>
        <input type="email" name="email" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Password *</label>
        <input type="password" name="password" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Role *</label>
        <select name="role" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
          <option value="operator">Operator</option>
          <option value="superadmin">Super Admin</option>
        </select>
      </div>
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg">Simpan</button>
    </form>
  </div>
</div>
@endsection