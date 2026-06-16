<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Barang</title>
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

        .badge-aktif   { background: #d1fae5; color: #065f46; padding: 2px 7px; border-radius: 10px; font-size: 9px; font-weight: bold; }
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
                    <h1 style="margin:0; font-size:16px; font-weight:bold; color:#1e3a5f">Laporan Data Barang</h1>
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
                <th>Lokasi</th>
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
                <td>{{ $item->location ?? '-' }}</td>
                <td style="text-align:center">
                    <span class="badge-aktif">{{ $item->status ?? 'Aktif' }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:20px; color:#9ca3af">
                    Tidak ada data barang.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        Total: {{ $items->count() }} barang
    </div>

</body>
</html>
