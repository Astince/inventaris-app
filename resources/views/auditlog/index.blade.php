@extends('layouts.app')
@section('title', 'Audit Log')
@section('page-title', 'Audit Log')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-xs font-bold text-white uppercase"
            style="background: linear-gradient(90deg, #1e3a5f, #2a4f80)">
          <th class="px-4 py-3 text-left">Waktu</th>
          <th class="px-4 py-3 text-left">Pengguna</th>
          <th class="px-4 py-3 text-left">Aksi</th>
          <th class="px-4 py-3 text-left">Keterangan</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($logs as $log)
        <tr class="hover:bg-gray-50">

          {{-- Waktu --}}
          <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
            {{ \Carbon\Carbon::parse($log->timestamp)->format('d/m/Y H:i:s') }}
          </td>

          {{-- Pengguna --}}
          <td class="px-4 py-3">
            <div class="font-medium text-gray-800">{{ $log->user->name ?? '—' }}</div>
            <div class="text-xs text-gray-400">{{ $log->user->role ?? '' }}</div>
          </td>

          {{-- Badge aksi dengan warna berbeda --}}
          <td class="px-4 py-3">
            @php
              $badge = match($log->action) {
                'LOGIN'           => ['bg:#e8eef5',  'color:#1e3a5f'],
                'LOGOUT'          => ['bg:#f1f5f9',  'color:#64748b'],
                'ADD_ITEM'        => ['bg:#e6f5ed',  'color:#145c37'],
                'EDIT_ITEM'       => ['bg:#fef9e7',  'color:#d4a800'],
                'DELETE_ITEM'     => ['bg:#fee2e2',  'color:#991b1b'],
                'TRANSACTION'     => ['bg:#ede9fe',  'color:#5b21b6'],
                'ADD_USER'        => ['bg:#e0f2fe',  'color:#0369a1'],
                'DELETE_USER'     => ['bg:#fee2e2',  'color:#991b1b'],
                'TOGGLE_USER'     => ['bg:#fef3c7',  'color:#92400e'],
                'ADD_CATEGORY'    => ['bg:#e6f5ed',  'color:#145c37'],
                'DELETE_CATEGORY' => ['bg:#fee2e2',  'color:#991b1b'],
                'ADD_UNIT'        => ['bg:#e6f5ed',  'color:#145c37'],
                'DELETE_UNIT'     => ['bg:#fee2e2',  'color:#991b1b'],
                default           => ['bg:#f3f4f6',  'color:#374151'],
              };
            @endphp
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                  style="background:{{ $badge[0] }}; color:{{ $badge[1] }}">
              {{ $log->action }}
            </span>
          </td>

          {{-- Keterangan --}}
          <td class="px-4 py-3 text-gray-600 text-xs">{{ $log->description }}</td>

        </tr>
        @empty
        <tr>
          <td colspan="4" class="px-4 py-12 text-center text-gray-400">Belum ada log aktivitas.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($logs->hasPages())
  <div class="px-4 py-3 border-t border-gray-100">{{ $logs->links() }}</div>
  @endif
</div>
@endsection
