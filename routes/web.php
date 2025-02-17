<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProdukController::class, 'index']); 

Route::resource('produk', ProdukController::class);
Route::resource('transaksi', TransaksiController::class);
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');