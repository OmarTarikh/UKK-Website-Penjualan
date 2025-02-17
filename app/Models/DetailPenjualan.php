<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDF; // Import DomPDF

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detailpenjualan';
    protected $primaryKey = 'DetailID';
    protected $fillable = ['PenjualanID', 'ProdukID', 'JumlahProduk', 'Subtotal'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'PenjualanID');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ProdukID');
    }

    public function exportPDF()
    {
        $detailPenjualan = DetailPenjualan::with(['penjualan', 'produk'])->get();

        $pdf = PDF::loadView('detailpenjualan.pdf', compact('detailPenjualan'));

        return $pdf->download('detail_penjualan.pdf');
    }

}
