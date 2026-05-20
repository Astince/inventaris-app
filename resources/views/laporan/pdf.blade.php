<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Barang</title>
    <style>
        /* Reset & font dasar */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1f2937; }

        /* Header laporan */
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #f5c518; padding-bottom: 12px; }
        .header h1 { font-size: 16px; font-weight: bold; color: #1e3a5f; }
        .header p  { font-size: 10px; color: #6b7280; margin-top: 3px; }

        /* Tabel */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead tr { background-color: #1e3a5f; color: #ffffff; }
        thead th { padding: 7px 8px; text-align: left; font-size: 10px; font-weight: bold; }
        tbody tr:nth-child(even) { background-color: #f3f4f6; }
        tbody tr:nth-child(odd)  { background-color: #ffffff; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; }

        /* Badge status */
        .badge-aman    { background: #d1fae5; color: #065f46; padding: 2px 7px; border-radius: 10px; font-size: 9px; font-weight: bold; }
        .badge-restok  { background: #fee2e2; color: #991b1b; padding: 2px 7px; border-radius: 10px; font-size: 9px; font-weight: bold; }

        /* Stok rendah */
        .stok-rendah { color: #dc2626; font-weight: bold; }

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
                    <h1 style="margin:0; font-size:16px; font-weight:bold; color:#1e3a5f">Laporan Stok Barang</h1>
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
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Unit</th>
                <th style="text-align:center">Stok</th>
                <th style="text-align:center">Min</th>
                <th style="text-align:center">Masuk</th>
                <th style="text-align:center">Keluar</th>
                <th style="text-align:center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $item->code }}</strong></td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ $item->unit->name ?? '-' }}</td>
                <td style="text-align:center" class="{{ $item->isLowStock() ? 'stok-rendah' : '' }}">
                    {{ $item->stock }}
                </td>
                <td style="text-align:center">{{ $item->min_stock }}</td>
                <td style="text-align:center; color:#059669"><strong>+{{ $item->total_masuk }}</strong></td>
                <td style="text-align:center; color:#dc2626"><strong>-{{ $item->total_keluar }}</strong></td>
                <td style="text-align:center">
                    @if($item->isLowStock())
                        <span class="badge-restok">Perlu Restok</span>
                    @else
                        <span class="badge-aman">Aman</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center; padding:20px; color:#9ca3af">
                    Tidak ada data barang.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        Total: {{ $items->count() }} barang &nbsp;|&nbsp;
        Stok rendah: {{ $items->filter(fn($i) => $i->isLowStock())->count() }} barang
    </div>

</body>
</html>
