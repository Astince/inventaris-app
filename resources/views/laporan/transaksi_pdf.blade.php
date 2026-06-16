<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Barang</title>
    <style>
        /* Reset & font dasar */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #1f2937; }

        /* Header laporan */
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #f5c518; padding-bottom: 12px; }
        .header h1 { font-size: 16px; font-weight: bold; color: #1e3a5f; }
        .header p  { font-size: 10px; color: #6b7280; margin-top: 3px; }

        /* Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead tr { background-color: #1e3a5f; color: #ffffff; }
        thead th { padding: 7px 8px; text-align: left; font-size: 9px; font-weight: bold; }
        tbody tr:nth-child(even) { background-color: #f3f4f6; }
        tbody tr:nth-child(odd)  { background-color: #ffffff; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; }

        .badge-masuk    { background: #d1fae5; color: #065f46; padding: 2px 7px; border-radius: 10px; font-size: 8px; font-weight: bold; }
        .badge-keluar  { background: #fee2e2; color: #991b1b; padding: 2px 7px; border-radius: 10px; font-size: 8px; font-weight: bold; }

        /* Footer */
        .footer { margin-top: 20px; font-size: 9px; color: #9ca3af; text-align: right; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <table style="width:100%; border:none; margin-bottom:0">
            <tr>
                <td style="width:60px; vertical-align:middle; border:none; padding:0">
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="width:50px; height:50px;">
                </td>
                <td style="vertical-align:middle; border:none; padding:0 0 0 10px">
                    <h1 style="margin:0; font-size:16px; font-weight:bold; color:#1e3a5f">Laporan Transaksi Barang</h1>
                    <p style="margin:3px 0 0; font-size:10px; color:#6b7280">
                        BAN-PDM Papua Barat &mdash; Dicetak pada: {{ $tanggal }}
                    </p>
                </td>
            </tr>
        </table>
    </div>

    {{-- Tabel Data --}}
    <table>
        <thead>
            <tr>
                <th style="width:30px">No</th>
                <th style="width:70px">Tanggal</th>
                <th style="width:70px">Kode Barang</th>
                <th>Nama Barang</th>
                <th style="width:60px; text-align:center">Tipe</th>
                <th style="width:70px; text-align:center">Qty</th>
                <th style="text-align:center">Stok Sblm</th>
                <th style="text-align:center">Stok Ssdh</th>
                <th>Sumber / Penerima</th>
                <th>Operator</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $i => $tx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</td>
                <td><strong>{{ $tx->item->code ?? '-' }}</strong></td>
                <td>{{ $tx->item->name ?? '-' }}</td>
                <td style="text-align:center">
                    @if($tx->transaction_type === 'in')
                        <span class="badge-masuk">Masuk</span>
                    @else
                        <span class="badge-keluar">Keluar</span>
                    @endif
                </td>
                <td style="text-align:center; {{ $tx->transaction_type === 'in' ? 'color:#059669;' : 'color:#dc2626;' }}">
                    <strong>{{ $tx->transaction_type === 'in' ? '+' : '-' }}{{ $tx->qty }} {{ $tx->item->unit->name ?? '' }}</strong>
                </td>
                <td style="text-align:center">{{ $tx->stock_before }} {{ $tx->item->unit->name ?? '' }}</td>
                <td style="text-align:center"><strong>{{ $tx->stock_after }} {{ $tx->item->unit->name ?? '' }}</strong></td>
                <td>{{ $tx->source ?? '-' }}</td>
                <td>{{ $tx->creator->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center; padding:20px; color:#9ca3af">
                    Tidak ada data transaksi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        Total: {{ $transactions->count() }} transaksi &nbsp;|&nbsp;
        Masuk: {{ $transactions->where('transaction_type', 'in')->count() }} &nbsp;|&nbsp;
        Keluar: {{ $transactions->where('transaction_type', 'out')->count() }}
    </div>

</body>
</html>
