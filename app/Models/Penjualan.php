<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDF; // Import DomPDF

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan'; 
    protected $primaryKey = 'PenjualanID'; 
    public $timestamps = true; 

    protected $fillable = [
        'TanggalPenjualan',
        'PelangganID',
    ];

    protected $guarded = ['TotalHarga'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'PelangganID', 'PelangganID');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'PenjualanID', 'PenjualanID');
    }

    public function getTotalHargaAttribute()
    {
        return $this->detailPenjualan->sum('Subtotal'); 
    }

    public function exportPDF()
    {
        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan.produk'])->get();

        $pdf = PDF::loadView('penjualan.pdf', compact('penjualan'));

        return $pdf->download('penjualan.pdf');
    }
}
