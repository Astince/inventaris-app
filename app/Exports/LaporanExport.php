<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    /**
     * Ambil semua data barang beserta relasi kategori dan unit.
     */
    public function collection()
    {
        $items = MasterItem::with(['category', 'unit'])->get();

        // Format data menjadi baris-baris sederhana
        return $items->map(function ($item, $index) {
            $totalMasuk  = $item->transactions()->where('transaction_type', 'in')->sum('qty');
            $totalKeluar = $item->transactions()->where('transaction_type', 'out')->sum('qty');
            $status      = $item->isLowStock() ? 'Perlu Restok' : 'Aman';

            return [
                'no'           => $index + 1,
                'code'         => $item->code,
                'name'         => $item->name,
                'category'     => $item->category->name ?? '-',
                'unit'         => $item->unit->name ?? '-',
                'stock'        => $item->stock,
                'min_stock'    => $item->min_stock,
                'total_masuk'  => $totalMasuk,
                'total_keluar' => $totalKeluar,
                'status'       => $status,
            ];
        });
    }

    /**
     * Baris judul kolom di baris pertama.
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Unit',
            'Stok',
            'Min. Stok',
            'Total Masuk',
            'Total Keluar',
            'Status',
        ];
    }

    /**
     * Atur lebar kolom agar mudah dibaca.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 30,
            'D' => 20,
            'E' => 10,
            'F' => 10,
            'G' => 12,
            'H' => 14,
            'I' => 14,
            'J' => 15,
        ];
    }

    /**
     * Beri style pada baris header (tebal & warna latar).
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            // Baris 1 = header: tebal, latar biru, teks putih
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    /**
     * Nama sheet di dalam file Excel.
     */
    public function title(): string
    {
        return 'Laporan Stok';
    }
}
