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
        $query = MasterItem::with(['category','unit']);
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($q2) => $q2->where('name','like',"%$q%")->orWhere('code','like',"%$q%"));
        }
        if ($request->filled('category_id')) $query->where('category_id',$request->category_id);
        $items = $query->latest()->paginate(15)->withQueryString();
        $categories = MasterCategory::all();
        return view('barang.index', compact('items','categories'));
    }

    public function create()
    {
        $categories = MasterCategory::all();
        $units = MasterUnit::all();
        return view('barang.create', compact('categories','units'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'        => 'required|string|max:50|unique:master_items,code',
            'name'        => 'required|string|max:100',
            'category_id' => 'required|exists:master_category,id',
            'unit_id'     => 'required|exists:master_unit,id',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'status'      => 'required|in:active,inactive',
        ]);
        $item = MasterItem::create($data);
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'ADD_ITEM','description'=>"Tambah barang: {$item->name}",'timestamp'=>now()]);
        return redirect()->route('barang.index')->with('success',"Barang '{$item->name}' berhasil ditambahkan.");
    }

    public function edit(MasterItem $barang)
    {
        $categories = MasterCategory::all();
        $units = MasterUnit::all();
        return view('barang.edit', compact('barang','categories','units'));
    }

    public function update(Request $request, MasterItem $barang)
    {
        $data = $request->validate([
            'code'        => "required|string|max:50|unique:master_items,code,{$barang->id}",
            'name'        => 'required|string|max:100',
            'category_id' => 'required|exists:master_category,id',
            'unit_id'     => 'required|exists:master_unit,id',
            'min_stock'   => 'required|integer|min:0',
            'location'    => 'nullable|string|max:100',
            'status'      => 'required|in:active,inactive',
        ]);
        $barang->update($data);
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'EDIT_ITEM','description'=>"Edit barang: {$barang->name}",'timestamp'=>now()]);
        return redirect()->route('barang.index')->with('success',"Barang '{$barang->name}' berhasil diperbarui.");
    }

    public function destroy(MasterItem $barang)
    {
        if ($barang->transactions()->count() > 0)
            return back()->with('error',"Barang tidak bisa dihapus karena memiliki riwayat transaksi.");
        $name = $barang->name;
        $barang->delete();
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'DELETE_ITEM','description'=>"Hapus barang: $name",'timestamp'=>now()]);
        return redirect()->route('barang.index')->with('success',"Barang '$name' berhasil dihapus.");
    }
}