<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>

<body style="font-family: Arial, sans-serif; text-align: center;">

    <h1>Edit Produk</h1>

    <form action="{{ route('produk.update', $produk->id) }}" method="POST"
        style="display: inline-block; text-align: left; padding: 30px; border: 1px solid black; border-radius: 10px; width: 250px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label for="nama_produk">Nama Produk:</label><br>
            <input type="text" name="nama_produk" id="nama_produk" value="{{ $produk->nama_produk }}" required
                style="width: 100%; padding: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="harga">Harga:</label><br>
            <input type="number" name="harga" id="harga" value="{{ $produk->harga }}" required
                style="width: 100%; padding: 5px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="stok">Stok:</label><br>
            <input type="number" name="stok" id="stok" value="{{ $produk->stok }}" required
                style="width: 100%; padding: 5px;">
        </div>

        <button type="submit"
            style="width: 100%; padding: 10px; background-color: blue; color: white; border: none; cursor: pointer; border-radius: 5px;">
            Simpan Perubahan
        </button>
    </form>

</body>

</html>
