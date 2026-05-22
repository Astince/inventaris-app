<?php
namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\MasterItem;
use App\Models\MasterCategory;
use App\Models\MasterUnit;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterItem::with(['category', 'unit']);
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($q2) => $q2->where('name', 'like', "%$q%")->orWhere('code', 'like', "%$q%"));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        $items      = $query->latest()->paginate(15)->withQueryString();
        $categories = MasterCategory::orderBy('name')->get();
        return view('barang.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories  = MasterCategory::orderBy('name')->get();
        $units       = MasterUnit::orderBy('name')->get();
        $nextCode    = ''; // akan di-generate via JS saat kategori dipilih
        return view('barang.create', compact('categories', 'units', 'nextCode'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'category_id' => 'required|exists:master_category,id',
            'unit_id'     => 'required|exists:master_unit,id',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'location'    => 'nullable|string|max:100',
        ]);

        // Kode generate otomatis berdasarkan kategori
        $data['code']      = MasterItem::generateCode((int) $data['category_id']);
        $data['min_stock'] = $data['min_stock'] ?? 0;

        $item = MasterItem::create($data);
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'ADD_ITEM',
            'description' => "Tambah barang: {$item->name} ({$item->code})",
            'timestamp'   => now(),
        ]);
        return redirect()->route('barang.index')->with('success', "Barang '{$item->name}' berhasil ditambahkan.");
    }

    public function edit(MasterItem $barang)
    {
        $categories = MasterCategory::orderBy('name')->get();
        $units      = MasterUnit::orderBy('name')->get();
        return view('barang.edit', compact('barang', 'categories', 'units'));
    }

    public function update(Request $request, MasterItem $barang)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'category_id' => 'required|exists:master_category,id',
            'unit_id'     => 'required|exists:master_unit,id',
            'min_stock'   => 'nullable|integer|min:0',
            'location'    => 'nullable|string|max:100',
        ]);
        $data['min_stock'] = $data['min_stock'] ?? 0;

        $barang->update($data);
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'EDIT_ITEM',
            'description' => "Edit barang: {$barang->name}",
            'timestamp'   => now(),
        ]);
        return redirect()->route('barang.index')->with('success', "Barang '{$barang->name}' berhasil diperbarui.");
    }

    // Preview kode otomatis saat kategori dipilih (dipanggil via fetch)
    public function previewKode(int $categoryId)
    {
        return response()->json([
            'code' => MasterItem::generateCode($categoryId)
        ]);
    }

    public function destroy(MasterItem $barang)    {
        if ($barang->transactions()->count() > 0) {
            return back()->with('error', "Barang tidak bisa dihapus karena memiliki riwayat transaksi.");
        }
        $name = $barang->name;
        $barang->delete();
        AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'DELETE_ITEM',
            'description' => "Hapus barang: $name",
            'timestamp'   => now(),
        ]);
        return redirect()->route('barang.index')->with('success', "Barang '$name' berhasil dihapus.");
    }
}
