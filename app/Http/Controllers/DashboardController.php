<?php
namespace App\Http\Controllers;
use App\Models\MasterItem;
use App\Models\ItemTransaction;
use App\Models\MasterCategory;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang  = MasterItem::where('status','active')->count();
        $totalMasuk   = ItemTransaction::where('transaction_type','in')->sum('qty');
        $totalKeluar  = ItemTransaction::where('transaction_type','out')->sum('qty');
        $stokRendah   = MasterItem::whereColumn('stock','<=','min_stock')->where('status','active')->count();
        $lowStockItems = MasterItem::with('unit')->whereColumn('stock','<=','min_stock')->where('status','active')->get();
        $recentTransactions = ItemTransaction::with(['item','creator'])->latest()->take(10)->get();
        $categories = MasterCategory::withSum('items as total_stock','stock')->get();

        return view('dashboard', compact(
            'totalBarang','totalMasuk','totalKeluar','stokRendah',
            'lowStockItems','recentTransactions','categories'
        ));
    }
}