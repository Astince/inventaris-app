<?php
namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'role'      => 'required|in:superadmin,operator',
            'is_active' => 'nullable|boolean',
        ]);
        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        $user = User::create($data);
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'ADD_USER',
            'description' => "Tambah akun: {$user->name} ({$user->role})",
            'timestamp'   => now(),
        ]);
        return back()->with('success', "Akun '{$user->name}' berhasil ditambahkan.");
    }

    // Toggle aktif / nonaktif
    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'TOGGLE_USER',
            'description' => "Akun {$user->name} {$status}",
            'timestamp'   => now(),
        ]);
        return back()->with('success', "Akun '{$user->name}' berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $name = $user->name;
        $user->delete();
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'DELETE_USER',
            'description' => "Hapus akun: $name",
            'timestamp'   => now(),
        ]);
        return back()->with('success', "Akun '$name' berhasil dihapus.");
    }
}
