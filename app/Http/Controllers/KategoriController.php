<?php
namespace App\Http\Controllers;
use App\Models\AuditLog;
use App\Models\MasterCategory;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $categories = MasterCategory::withCount('items')->get();
        return view('kategori.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:100|unique:master_category,name']);
        $kat = MasterCategory::create($data);
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'ADD_CATEGORY','description'=>"Tambah kategori: {$kat->name}",'timestamp'=>now()]);
        return back()->with('success',"Kategori '{$kat->name}' berhasil ditambahkan.");
    }
    public function destroy(MasterCategory $kategori)
    {
        if ($kategori->items()->count() > 0)
            return back()->with('error',"Kategori masih digunakan.");
        $name = $kategori->name;
        $kategori->delete();
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'DELETE_CATEGORY','description'=>"Hapus kategori: $name",'timestamp'=>now()]);
        return back()->with('success',"Kategori '$name' berhasil dihapus.");
    }
}