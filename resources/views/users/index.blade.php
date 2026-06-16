@extends('layouts.app')
@section('title','Kelola Akun')
@section('page-title','Kelola Akun')

@section('content')
@php $isSuperAdmin = auth()->user()->role === 'superadmin'; @endphp

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
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#e8eef5; color:#1e3a5f">Super Admin</span>
            @else
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">Operator</span>
            @endif
          </td>
          <td class="px-4 py-3 text-center">
            @if($user->is_active)
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#e6f5ed; color:#145c37">Aktif</span>
            @else
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-50 text-red-600">Nonaktif</span>
            @endif
          </td>
          <td class="px-4 py-3">

            {{-- Akun sendiri: tombol Edit Profil untuk semua role --}}
            @if($user->id === auth()->id())
              <button type="button"
                      onclick="bukaEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')"
                      class="w-full text-xs px-3 py-1.5 rounded-lg font-medium transition-colors"
                      style="background:#e8eef5; color:#1e3a5f">
                Edit Profil
              </button>

            {{-- Akun orang lain: superadmin punya tombol lengkap --}}
            @elseif($isSuperAdmin)
              <div class="flex flex-col gap-1.5">
                <button type="button"
                        onclick="bukaEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')"
                        class="w-full text-xs px-3 py-1.5 rounded-lg font-medium transition-colors"
                        style="background:#e8eef5; color:#1e3a5f">
                  Edit
                </button>
                <form action="{{ route('users.toggle', $user) }}" method="POST">
                  @csrf @method('PATCH')
                  <button type="submit"
                          class="w-full text-xs px-3 py-1.5 rounded-lg font-medium transition-colors
                                 {{ $user->is_active ? 'bg-yellow-50 hover:bg-yellow-100 text-yellow-700' : 'bg-green-50 hover:bg-green-100 text-green-700' }}">
                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                  </button>
                </form>
                <form action="{{ route('users.destroy', $user) }}" method="POST"
                      onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }}?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="w-full text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg">
                    Hapus
                  </button>
                </form>
              </div>

            {{-- Operator melihat akun orang lain: hanya tampilan, tidak ada aksi --}}
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

  {{-- ===== PANEL KANAN ===== --}}
  <div>

    {{-- Form Tambah Akun — hanya superadmin --}}
    @if($isSuperAdmin)
    <div id="panelTambah" class="bg-white rounded-xl border border-gray-200 p-6">
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
          <div class="relative">
            <input type="password" id="tambahPassword" name="password" placeholder="Min. 8 karakter"
              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 pr-10 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
            <button type="button" onclick="togglePw('tambahPassword', this)" title="Tampilkan password"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
              </svg>
            </button>
          </div>
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
                class="w-full text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:opacity-90"
                style="background:#1e3a5f">
          Buat Akun
        </button>
      </form>
    </div>
    @else
    {{-- Operator: tampilkan info singkat --}}
    <div id="panelTambah" class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col items-center justify-center text-center gap-3" style="min-height:200px">
      <svg class="w-10 h-10 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
      </svg>
      <div>
        <p class="text-sm font-semibold text-gray-600">Klik <strong>Edit Profil</strong> pada baris akun Anda</p>
        <p class="text-xs text-gray-400 mt-1">untuk mengubah nama, email, atau password</p>
      </div>
    </div>
    @endif

    {{-- Form Edit Akun (muncul saat klik Edit / Edit Profil) --}}
    <div id="panelEdit" class="hidden bg-white rounded-xl border-2 border-blue-200 p-6 {{ $isSuperAdmin ? 'mt-5' : '' }}">
      <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2">
          <div class="w-1 h-5 rounded-full" style="background:#1e3a5f"></div>
          <h2 class="text-sm font-bold text-gray-800">Edit Akun: <span id="editNamaJudul" class="text-blue-700"></span></h2>
        </div>
        <button type="button" onclick="tutupEdit()"
                class="text-xs text-gray-400 hover:text-gray-600 border border-gray-200 px-2 py-1 rounded-lg">
          ✕ Tutup
        </button>
      </div>

      <form id="formEdit" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
          <input type="text" id="editNama" name="name" placeholder="Nama pengguna"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email *</label>
          <input type="email" id="editEmail" name="email" placeholder="email@kantor.com"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
        </div>

        <div>
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Password Baru
            <span class="text-gray-400 font-normal normal-case">(kosongkan jika tidak diubah)</span>
          </label>
          <div class="relative">
            <input type="password" id="editPassword" name="password" placeholder="Isi jika ingin ganti password"
              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 pr-10 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50">
            <button type="button" onclick="togglePw('editPassword', this)" title="Tampilkan password"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
              </svg>
            </button>
          </div>
        </div>

        <div id="editRoleWrap">
          <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Role *</label>
          <select id="editRole" name="role"
                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-blue-400">
            <option value="operator">Operator</option>
            <option value="superadmin">Super Admin</option>
          </select>
        </div>

        <div class="flex gap-3 pt-1">
          <button type="button" onclick="tutupEdit()"
                  class="flex-1 border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50">
            Batal
          </button>
          <button type="submit"
                  class="flex-1 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:opacity-90"
                  style="background:#1e3a5f">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>

  </div>
</div>

<script>
const baseUrl    = '{{ url("/users") }}';
const authUserId = {{ auth()->id() }};

function togglePw(inputId, btn) {
    const input    = document.getElementById(inputId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.innerHTML  = isHidden
        ? `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27z"/></svg>`
        : `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>`;
    btn.title = isHidden ? 'Sembunyikan' : 'Tampilkan';
}

function bukaEdit(id, nama, email, role) {
    document.getElementById('editNamaJudul').textContent = nama;
    document.getElementById('editNama').value  = nama;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value  = role;
    document.getElementById('formEdit').action = baseUrl + '/' + id;

    // Sembunyikan Role jika edit akun sendiri
    document.getElementById('editRoleWrap').style.display = (id === authUserId) ? 'none' : '';

    document.getElementById('panelTambah').classList.add('hidden');
    document.getElementById('panelEdit').classList.remove('hidden');
    document.getElementById('panelEdit').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function tutupEdit() {
    document.getElementById('panelEdit').classList.add('hidden');
    document.getElementById('panelTambah').classList.remove('hidden');
}
</script>
@endsection
