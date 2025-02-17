<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('PenjualanID');
            $table->date('TanggalPenjualan');
            $table->unsignedBigInteger('PelangganID');
            $table->decimal('TotalHarga', 10, 2)->default(0)->comment('Automatically calculated from detailpenjualan');
            $table->timestamps();
        
            $table->foreign('PelangganID')->references('PelangganID')->on('pelanggan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
