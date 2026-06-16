@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-sm">
    <div class="bg-white rounded-xl border border-gray-200 p-8 flex flex-col items-center text-center gap-4">

        {{-- Avatar besar --}}
        <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-3xl font-bold text-white"
             style="background: linear-gradient(135deg, #1e3a5f, #2a4f80)">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>

        {{-- Nama --}}
        <div>
            <h2 class="text-lg font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
        </div>

        {{-- Badge role --}}
        <span class="text-xs font-semibold px-3 py-1 rounded-full"
              style="{{ $user->role === 'superadmin' ? 'background:#e8eef5; color:#1e3a5f' : 'background:#f3f4f6; color:#374151' }}">
            {{ $user->role === 'superadmin' ? 'Super Admin' : 'Operator' }}
        </span>

        {{-- Divider --}}
        <div class="w-full border-t border-gray-100"></div>

        {{-- Status --}}
        <div class="flex items-center gap-2 text-xs text-gray-500">
            <span class="w-2 h-2 rounded-full inline-block" style="background:#1a7a4a"></span>
            Akun Aktif
        </div>

    </div>
</div>
@endsection
