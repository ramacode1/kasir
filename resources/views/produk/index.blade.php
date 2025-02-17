<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center;">

    <h1>Daftar Produk</h1>
    <a href="{{ route('produk.create') }}" style="margin-right: 20px;">Tambah Produk</a>
    <a href="{{ route('transaksi.create') }}">Lakukan Transaksi</a>

    <table border="1" style="margin: 20px auto; border-collapse: collapse; width: 80%;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 10px; text-align: center; background-color: #f4f4f4;">Nama Produk</th>
                <th style="border: 1px solid black; padding: 10px; text-align: center; background-color: #f4f4f4;">Harga</th>
                <th style="border: 1px solid black; padding: 10px; text-align: center; background-color: #f4f4f4;">Stok</th>
                <th style="border: 1px solid black; padding: 10px; text-align: center; background-color: #f4f4f4;">Barcode</th>
                <th style="border: 1px solid black; padding: 10px; text-align: center; background-color: #f4f4f4;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($produks->count() > 0)
                @foreach ($produks as $produk)
                    <tr>
                        <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $produk->nama_produk }}</td>
                        <td style="border: 1px solid black; padding: 10px; text-align: center;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $produk->stok }}</td>
                        <td style="border: 1px solid black; padding: 10px; text-align: center;">
                            @if ($produk->barcode)
                                <div style="width: 120px; overflow: hidden; margin: 0 auto;">
                                    <div style="display: inline-block; width: 100%;">
                                        {!! DNS1D::getBarcodeHTML($produk->barcode, 'C39', 1.5, 40) !!}
                                    </div>
                                </div>
                            @else
                                <span>Tidak ada barcode</span>
                            @endif
                        </td>
                        <td style="border: 1px solid black; padding: 10px; text-align: center;">
                            <a href="{{ route('produk.edit', $produk->id) }}" style="margin-right: 10px;">Edit</a>
                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" style="background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="border: 1px solid black; padding: 10px; text-align: center;">Tidak ada data produk.</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>
</html>
