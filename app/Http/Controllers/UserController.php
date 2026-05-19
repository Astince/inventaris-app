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
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:superadmin,operator',
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'ADD_USER','description'=>"Tambah user: {$user->name}",'timestamp'=>now()]);
        return back()->with('success',"User '{$user->name}' berhasil ditambahkan.");
    }
    public function destroy(User $user)
    {
        if ($user->id === auth()->id())
            return back()->with('error','Tidak bisa menghapus akun sendiri.');
        $name = $user->name;
        $user->delete();
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'DELETE_USER','description'=>"Hapus user: $name",'timestamp'=>now()]);
        return back()->with('success',"User '$name' berhasil dihapus.");
    }
}