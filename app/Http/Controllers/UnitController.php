<?php
namespace App\Http\Controllers;
use App\Models\AuditLog;
use App\Models\MasterUnit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = MasterUnit::withCount('items')->get();
        return view('unit.index', compact('units'));
    }
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:50|unique:master_unit,name']);
        $unit = MasterUnit::create($data);
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'ADD_UNIT','description'=>"Tambah unit: {$unit->name}",'timestamp'=>now()]);
        return back()->with('success',"Unit '{$unit->name}' berhasil ditambahkan.");
    }
    public function destroy(MasterUnit $unit)
    {
        if ($unit->items()->count() > 0)
            return back()->with('error',"Unit masih digunakan.");
        $name = $unit->name;
        $unit->delete();
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'DELETE_UNIT','description'=>"Hapus unit: $name",'timestamp'=>now()]);
        return back()->with('success',"Unit '$name' berhasil dihapus.");
    }
}