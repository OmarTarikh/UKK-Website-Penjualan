<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class DetailPenjualanController extends Controller
{
    /**
     * Display a listing of the detail penjualan.
     *
     * @return View
     */
    public function index(): View
    {
        $detailpenjualan = DetailPenjualan::with(['penjualan', 'produk'])->latest()->get();
        $penjualan = Penjualan::all();
        $produk = Produk::all();
    
        return view('detailpenjualan.index', compact('detailpenjualan', 'penjualan', 'produk'));
    }
    
    /**
     * Store a newly created detail penjualan in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'PenjualanID' => 'required|exists:penjualan,PenjualanID',
            'ProdukID' => 'required|exists:produk,ProdukID',
            'JumlahProduk' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $produk = Produk::find($request->ProdukID);
                    if ($value > $produk->Stok) {
                        $fail("Jumlah Produk tidak boleh lebih besar dari stok yang tersedia ({$produk->Stok}).");
                    }
                }
            ],
        ]);
    
        $produk = Produk::find($request->ProdukID);
        $subtotal = $produk->Harga * $request->JumlahProduk;
    
        DetailPenjualan::create([
            'PenjualanID' => $request->PenjualanID,
            'ProdukID' => $request->ProdukID,
            'JumlahProduk' => $request->JumlahProduk,
            'Subtotal' => $subtotal,
        ]);
    
        return redirect()->route('detailpenjualan.index')->with('success', 'Detail Penjualan berhasil ditambahkan.');
    }
    
    /**
     * Show the form for editing the specified detail penjualan.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $detailPenjualan = DetailPenjualan::findOrFail($id);
        $penjualan = Penjualan::all();
        $produk = Produk::all();

        return view('detailpenjualan.edit', compact('detailPenjualan', 'penjualan', 'produk'));
    }

    /**
     * Update the specified detail penjualan in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'PenjualanID' => 'required|exists:penjualan,PenjualanID',
            'ProdukID' => 'required|exists:produk,ProdukID',
            'JumlahProduk' => 'required|integer|min:1',
        ]);

        $detailPenjualan = DetailPenjualan::findOrFail($id);
        $produk = Produk::findOrFail($request->ProdukID);
        $subtotal = $produk->Harga * $request->JumlahProduk;

        // Update detail penjualan
        $detailPenjualan->update([
            'PenjualanID' => $request->PenjualanID,
            'ProdukID' => $request->ProdukID,
            'JumlahProduk' => $request->JumlahProduk,
            'Subtotal' => $subtotal,
        ]);

        return redirect()->route('detailpenjualan.index')->with('success', 'Detail Penjualan berhasil diperbarui!');
    }

    /**
     * Remove the specified detail penjualan from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $detailPenjualan = DetailPenjualan::findOrFail($id);
        $detailPenjualan->delete();

        return redirect()->route('detailpenjualan.index')->with('success', 'Detail Penjualan berhasil dihapus!');
    }
        /**
     * Export DetailPenjualan data to PDF.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPDF()
    {
        $detailPenjualan = DetailPenjualan::with(['penjualan', 'produk'])->get();
    
        $pdf = PDF::loadView('detailpenjualan.pdf', compact('detailPenjualan'))
                ->setPaper('a4', 'landscape');
    
        return $pdf->download('laporan_detail_penjualan.pdf');
    }
        /**
     * Show the details of a specific detail penjualan.
     *
     * @param int $id
     * @return View
     */
    public function show($id): View
    {
        $detailPenjualan = DetailPenjualan::with(['penjualan', 'produk'])->findOrFail($id);
        return view('detailpenjualan.show', compact('detailPenjualan'));
    }

}
