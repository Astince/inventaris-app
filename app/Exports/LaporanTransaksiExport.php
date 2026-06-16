<?php

namespace App\Exports;

use App\Models\ItemTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanTransaksiExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $type;
    protected $from;
    protected $to;

    public function __construct($type = null, $from = null, $to = null)
    {
        $this->type = $type;
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $query = ItemTransaction::with(['item.unit', 'creator']);

        if ($this->type) {
            $query->where('transaction_type', $this->type);
        }
        if ($this->from) {
            $query->whereDate('date', '>=', $this->from);
        }
        if ($this->to) {
            $query->whereDate('date', '<=', $this->to);
        }

        $transactions = $query->latest('date')->get();

        return $transactions->map(function ($tx, $index) {
            return [
                'no'               => $index + 1,
                'date'             => $tx->date->format('d/m/Y'),
                'code'             => $tx->item->code ?? '-',
                'name'             => $tx->item->name ?? '-',
                'type'             => $tx->transaction_type === 'in' ? 'Barang Masuk' : 'Barang Keluar',
                'qty'              => ($tx->transaction_type === 'in' ? '+' : '-') . $tx->qty,
                'unit'             => $tx->item->unit->name ?? '-',
                'stock_before'     => $tx->stock_before,
                'stock_after'      => $tx->stock_after,
                'source'           => $tx->source ?? '-',
                'operator'         => $tx->creator->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Kode Barang',
            'Nama Barang',
            'Tipe Transaksi',
            'Jumlah (Qty)',
            'Satuan',
            'Stok Sebelum',
            'Stok Sesudah',
            'Sumber / Penerima',
            'Operator',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 15,
            'D' => 25,
            'E' => 15,
            'F' => 15,
            'G' => 10,
            'H' => 15,
            'I' => 15,
            'J' => 25,
            'K' => 20,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }
}
