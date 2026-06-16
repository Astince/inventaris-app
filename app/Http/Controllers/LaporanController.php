<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Exports\LaporanTransaksiExport;
use App\Exports\LaporanBarangExport;
use App\Models\MasterItem;
use App\Models\ItemTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Ambil data barang dan kirim ke view laporan.
     */
    private function getItems()
{
    return MasterItem::with(['category', 'unit'])
        ->withSum(['transactions as total_masuk' => fn($q) => $q->where('transaction_type', 'in')], 'qty')
        ->withSum(['transactions as total_keluar' => fn($q) => $q->where('transaction_type', 'out')], 'qty')
        ->get();
}

    /**
     * Tampilkan halaman laporan gabungan.
     */
    public function index(Request $request)
    {
        $items = $this->getItems();

        // Load data transaksi dengan filter
        $query = ItemTransaction::with(['item.unit', 'creator']);

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }
        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $transactions = $query->latest('date')->get();
        $tab = $request->get('tab', 'barang');

        return view('laporan.index', compact('items', 'transactions', 'tab'));
    }

    /**
     * Download laporan barang dalam format PDF.
     */
    public function exportBarangPdf()
    {
        $items     = MasterItem::with(['category', 'unit'])->get();
        $tanggal   = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('laporan.barang_pdf', compact('items', 'tanggal'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-' . now()->format('Ymd') . '.pdf');
    }

    /**
     * Download laporan barang dalam format Excel (.xlsx).
     */
    public function exportBarangExcel()
    {
        $namaFile = 'laporan-barang-' . now()->format('Ymd') . '.xlsx';
        return Excel::download(new LaporanBarangExport, $namaFile);
    }

    /**
     * Download laporan stok dalam format PDF.
     */
    public function exportStokPdf()
    {
        $items     = $this->getItems();
        $tanggal   = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('laporan.pdf', compact('items', 'tanggal'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-stok-' . now()->format('Ymd') . '.pdf');
    }

    /**
     * Download laporan stok dalam format Excel (.xlsx).
     */
    public function exportStokExcel()
    {
        $namaFile = 'laporan-stok-' . now()->format('Ymd') . '.xlsx';
        return Excel::download(new LaporanExport, $namaFile);
    }

    /**
     * Redirect ke halaman laporan gabungan tab transaksi.
     */
    public function transaksi(Request $request)
    {
        return redirect()->route('laporan.index', array_merge(['tab' => 'transaksi'], $request->all()));
    }

    /**
     * Download laporan transaksi PDF.
     */
    public function exportTransaksiPdf(Request $request)
    {
        $query = ItemTransaction::with(['item.unit', 'creator']);

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }
        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $transactions = $query->latest('date')->get();
        $tanggal   = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('laporan.transaksi_pdf', compact('transactions', 'tanggal'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi-' . now()->format('Ymd') . '.pdf');
    }

    /**
     * Download laporan transaksi Excel.
     */
    public function exportTransaksiExcel(Request $request)
    {
        $namaFile = 'laporan-transaksi-' . now()->format('Ymd') . '.xlsx';
        return Excel::download(new LaporanTransaksiExport(
            $request->type,
            $request->from,
            $request->to
        ), $namaFile);
    }
}