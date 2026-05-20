@extends('layouts.app')
@section('title','Audit Log')
@section('page-title','Audit Log')
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead><tr class="bg-gray-50 text-xs text-gray-500 uppercase">
        <th class="px-4 py-3 text-left">Waktu</th>
        <th class="px-4 py-3 text-left">User</th>
        <th class="px-4 py-3 text-left">Aksi</th>
        <th class="px-4 py-3 text-left">Deskripsi</th>
      </tr></thead>
      <tbody class="divide-y divide-gray-100">
        @forelse($logs as $log)
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3 text-gray-500 text-xs">{{ $log->timestamp }}</td>
          <td class="px-4 py-3 font-medium text-gray-800">{{ $log->user->name ?? '-' }}</td>
          <td class="px-4 py-3"><span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $log->action }}</span></td>
          <td class="px-4 py-3 text-gray-600">{{ $log->description }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="px-4 py-12 text-center text-gray-400">Belum ada log.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($logs->hasPages())
  <div class="px-4 py-3 border-t border-gray-100">{{ $logs->links() }}</div>
  @endif
</div>
@endsection