<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\MasterItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Ambil data barang dan kirim ke view laporan.
     */
    private function getItems()
    {
        return MasterItem::with(['category', 'unit'])->get()->map(function ($item) {
            $item->total_masuk  = $item->transactions()->where('transaction_type', 'in')->sum('qty');
            $item->total_keluar = $item->transactions()->where('transaction_type', 'out')->sum('qty');
            return $item;
        });
    }

    /**
     * Tampilkan halaman laporan stok.
     */
    public function index()
    {
        $items = $this->getItems();
        return view('laporan.index', compact('items'));
    }

    /**
     * Download laporan dalam format PDF.
     */
    public function exportPdf()
    {
        $items     = $this->getItems();
        $tanggal   = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('laporan.pdf', compact('items', 'tanggal'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-stok-' . now()->format('Ymd') . '.pdf');
    }

    /**
     * Download laporan dalam format Excel (.xlsx).
     */
    public function exportExcel()
    {
        $namaFile = 'laporan-stok-' . now()->format('Ymd') . '.xlsx';
        return Excel::download(new LaporanExport, $namaFile);
    }
}