<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function create()
    {
        $produks = Produk::all(); 
        return view('produk.transaksi', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        DB::beginTransaction();
        
        try {
            $totalHarga = 0;

            $transaksi = Transaksi::create([
                'total_harga' => 0, 
            ]);

            foreach ($request->produk_id as $key => $produk_id) {
                $produk = Produk::findOrFail($produk_id);
                $jumlah = $request->jumlah[$key];

                // Cek apakah stok mencukupi
                if ($produk->stok < $jumlah) {
                    DB::rollBack(); // Rollback transaksi jika stok tidak mencukupi
                    return back()->with('error', "Stok untuk {$produk->nama_produk} tidak mencukupi!");
                }

                // Kurangi stok produk
                $produk->stok -= $jumlah;
                $produk->save();

                // Hitung subtotal produk
                $subtotal = $produk->harga * $jumlah;
                $totalHarga += $subtotal;

                // Simpan detail transaksi
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produk->id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update total harga pada transaksi
            $transaksi->total_harga = $totalHarga;
            $transaksi->save();

            DB::commit();
            return redirect()->route('transaksi.create')->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
