<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $pelanggan = Pelanggan::count();
        $produk = Produk::count();
        $penjualan = Penjualan::count();
    
        // Total stok currently available
        $totalStok = Produk::sum('Stok');
    
        // Total produk terjual (pengeluaran stok)
        $totalPengeluaran = DetailPenjualan::sum('JumlahProduk');
    
        // Total pemasukan stok (produk baru atau stok yang bertambah dalam 30 hari terakhir)
        $pemasukanStok = Produk::whereDate('created_at', '>=', now()->subDays(30))->sum('Stok');
    
        return view('dashboard.index', compact('users', 'pelanggan', 'produk', 'penjualan', 'totalStok', 'totalPengeluaran', 'pemasukanStok'));
    }
}
