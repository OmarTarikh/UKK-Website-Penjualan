<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Explicitly defining the table name

    protected $primaryKey = 'ProdukID'; // Custom primary key

    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'NamaProduk',
        'Harga',
        'Stok',
    ];
}
