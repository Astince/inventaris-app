<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\MasterCategory;
use App\Models\MasterUnit;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Tampilkan halaman gabungan Kategori + Unit.
     */
    public function index()
    {
        $categories = MasterCategory::withCount('items')->orderBy('name')->get();
        $units      = MasterUnit::withCount('items')->orderBy('name')->get();

        return view('master-data.index', compact('categories', 'units'));
    }

    // ── KATEGORI ──────────────────────────────────────────

    public function storeKategori(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:master_category,name',
        ]);

        $kat = MasterCategory::create($data);
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'ADD_CATEGORY',
            'description' => "Tambah kategori: {$kat->name}",
            'timestamp'   => now(),
        ]);

        return back()->with('success', "Kategori '{$kat->name}' berhasil ditambahkan.");
    }

    public function destroyKategori(MasterCategory $kategori)
    {
        if ($kategori->items()->count() > 0) {
            return back()->with('error', "Kategori '{$kategori->name}' masih digunakan oleh barang.");
        }

        $name = $kategori->name;
        $kategori->delete();
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'DELETE_CATEGORY',
            'description' => "Hapus kategori: $name",
            'timestamp'   => now(),
        ]);

        return back()->with('success', "Kategori '$name' berhasil dihapus.");
    }

    // ── UNIT ──────────────────────────────────────────────

    public function storeUnit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:master_unit,name',
        ]);

        $unit = MasterUnit::create($data);
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'ADD_UNIT',
            'description' => "Tambah unit: {$unit->name}",
            'timestamp'   => now(),
        ]);

        return back()->with('success', "Unit '{$unit->name}' berhasil ditambahkan.");
    }

    public function destroyUnit(MasterUnit $unit)
    {
        if ($unit->items()->count() > 0) {
            return back()->with('error', "Unit '{$unit->name}' masih digunakan oleh barang.");
        }

        $name = $unit->name;
        $unit->delete();
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'DELETE_UNIT',
            'description' => "Hapus unit: $name",
            'timestamp'   => now(),
        ]);

        return back()->with('success', "Unit '$name' berhasil dihapus.");
    }
}
