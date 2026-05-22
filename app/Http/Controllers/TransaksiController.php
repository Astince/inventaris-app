<?php
namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\ItemTransaction;
use App\Models\MasterItem;
use App\Models\MasterCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transactions = ItemTransaction::with(['item', 'creator'])->latest()->paginate(15);
        return view('transaksi.index', compact('transactions'));
    }

    // Halaman riwayat — hanya lihat, ada filter, tanpa tombol input
    public function riwayat(Request $request)
    {
        $query = ItemTransaction::with(['item', 'creator']);

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('item', fn($q2) => $q2->where('name', 'like', "%$q%")->orWhere('code', 'like', "%$q%"));
        }
        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();
        return view('transaksi.riwayat', compact('transactions'));
    }

    public function create(Request $request)
    {
        $type       = $request->get('type', 'in');
        $items      = MasterItem::with('unit')->orderBy('name')->get();
        $categories = MasterCategory::orderBy('name')->get();
        return view('transaksi.create', compact('type', 'items', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id'          => 'required|exists:master_items,id',
            'transaction_type' => 'required|in:in,out',
            'qty'              => 'required|integer|min:1',
            'date'             => 'required|date',
            'source'           => 'nullable|string|max:100',
            'note'             => 'nullable|string',
        ]);

        $item = MasterItem::findOrFail($data['item_id']);

        if ($data['transaction_type'] === 'out' && $item->stock < $data['qty']) {
            return back()
                ->withErrors(['qty' => "Stok tidak cukup! Stok saat ini: {$item->stock}"])
                ->withInput();
        }

        DB::transaction(function () use ($data, $item) {
            $sb = $item->stock;
            $sa = $data['transaction_type'] === 'in' ? $sb + $data['qty'] : $sb - $data['qty'];
            $item->update(['stock' => $sa]);
            ItemTransaction::create([
                ...$data,
                'stock_before' => $sb,
                'stock_after'  => $sa,
                'created_by'   => auth()->id(),
            ]);
            $tipe = $data['transaction_type'] === 'in' ? 'masuk' : 'keluar';
            AuditLog::create([
                'user_id'     => auth()->id(),
                'action'      => 'TRANSACTION',
                'description' => "Transaksi {$tipe}: {$item->name} qty {$data['qty']}",
                'timestamp'   => now(),
            ]);
        });

        $tipe = $data['transaction_type'] === 'in' ? 'masuk' : 'keluar';
        return redirect()->route('transaksi.index')
            ->with('success', "Transaksi barang {$tipe} berhasil disimpan.");
    }
}
