<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center;">

<!-- alert -->
@if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div style="color: red;">{{ session('error') }}</div>
@endif

    <h1>Transaksi</h1>

    <div style="display: flex; justify-content: center; gap: 20px;">
        <div style="padding: 20px; border: 1px solid black; border-radius: 10px; width: 350px; text-align: left;">
            <h3>Input Pesanan</h3>
            <form id="transaksiForm" action="{{ route('transaksi.store') }}" method="POST">
                @csrf

                <div id="produk-list">
                    <div class="produk-item" style="margin-bottom: 15px;">
                        <label>Pilih Produk:</label><br>
                        <select name="produk_id[]" class="produk" required style="width: 100%; padding: 5px;" onchange="hitungTotal()">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}">
                                    {{ $produk->nama_produk }} 
                                </option>
                            @endforeach
                        </select>

                        <label>Jumlah:</label>
                        <input type="number" name="jumlah[]" class="jumlah" min="1" required style="width: 100%; padding: 5px;" oninput="hitungTotal()">
                        
                        <button type="button" onclick="hapusProduk(this)" style="margin-top: 5px; background-color: red; color: white; border: none; padding: 5px; cursor: pointer; border-radius: 5px;">
                            Hapus
                        </button>
                    </div>
                </div>

                <button type="button" onclick="tambahProduk()" style="width: 100%; padding: 10px; background-color: green; color: white; border: none; cursor: pointer; border-radius: 5px;">
                    Tambah Produk
                </button>

                <div style="margin-top: 15px;">
                    <label>Jumlah Bayar:</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" min="0" required style="width: 100%; padding: 5px;" oninput="hitungKembalian()">
                </div>

                <button type="submit" style="width: 100%; padding: 10px; background-color: blue; color: white; border: none; cursor: pointer; border-radius: 5px; margin-top: 10px;">
                    Proses Transaksi
                </button>
            </form>

            <button onclick="window.location.href='/produk'" style="width: 100%; padding: 10px; background-color: gray; color: white; border: none; cursor: pointer; border-radius: 5px; margin-top: 10px;">
                Kembali ke Produk
            </button>

        </div>

        <div style="padding: 20px; border: 1px solid black; border-radius: 10px; width: 300px; text-align: left;">
            <h3>Ringkasan Transaksi</h3>
            <p><strong>Total Harga:</strong> Rp <span id="total_harga">0</span></p>
            <p><strong>Kembalian:</strong> Rp <span id="kembalian">0</span></p>
        </div>

    </div>

    <script>
        function tambahProduk() {
            const produkList = document.getElementById('produk-list');

            const produkItem = document.createElement('div');
            produkItem.classList.add('produk-item');
            produkItem.style.marginBottom = "15px";

            produkItem.innerHTML = `
                <label>Pilih Produk:</label><br>
                <select name="produk_id[]" class="produk" required style="width: 100%; padding: 5px;" onchange="hitungTotal()">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}">
                            {{ $produk->nama_produk   }}
                        </option>
                    @endforeach
                </select>

                <label>Jumlah:</label>
                <input type="number" name="jumlah[]" class="jumlah" min="1" required style="width: 100%; padding: 5px;" oninput="hitungTotal()">
                
                <button type="button" onclick="hapusProduk(this)" style="margin-top: 5px; background-color: red; color: white; border: none; padding: 5px; cursor: pointer; border-radius: 5px;">
                    Hapus
                </button>
            `;

            produkList.appendChild(produkItem);
        }

        function hapusProduk(button) {
            button.parentElement.remove();
            hitungTotal();
        }

        function hitungTotal() {
            let totalHarga = 0;
            const produkItems = document.querySelectorAll('.produk-item');

            produkItems.forEach(item => {
                const select = item.querySelector('.produk');
                const jumlah = item.querySelector('.jumlah');
                const harga = select.options[select.selectedIndex]?.getAttribute('data-harga') || 0;
                const jumlahValue = jumlah.value || 1;
                totalHarga += harga * jumlahValue;
            });

            document.getElementById('total_harga').innerText = totalHarga.toLocaleString('id-ID');
            hitungKembalian();
        }

        function hitungKembalian() {
            const totalHarga = parseInt(document.getElementById('total_harga').innerText.replace(/\D/g, '')) || 0;
            const jumlahBayar = parseInt(document.getElementById('jumlah_bayar').value) || 0;
            const kembalian = jumlahBayar - totalHarga;
            document.getElementById('kembalian').innerText = kembalian >= 0 ? kembalian.toLocaleString('id-ID') : 0;
        }
    </script>

</body>
</html>
