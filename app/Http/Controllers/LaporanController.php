<?php
namespace App\Http\Controllers;
use App\Models\MasterItem;

class LaporanController extends Controller
{
    public function index()
    {
        $items = MasterItem::with(['category','unit'])->get()->map(function($item) {
            $item->total_masuk  = $item->transactions()->where('transaction_type','in')->sum('qty');
            $item->total_keluar = $item->transactions()->where('transaction_type','out')->sum('qty');
            return $item;
        });
        return view('laporan.index', compact('items'));
    }
}