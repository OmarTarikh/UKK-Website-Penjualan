<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB; // Query Builder untuk memanggil store procedure

class PenjualanController extends Controller
{
    /**
     * Display a listing of penjualan.
     *
     * @return View
     */
    public function index(): View
    {
        $penjualan = Penjualan::with('pelanggan')->latest()->get();
        $pelanggan = Pelanggan::all();
        return view('penjualan.index', compact('penjualan', 'pelanggan'));
    }

    /**
     * Show the form for creating a new penjualan.
     *
     * @return View
     */
    public function create(): View
    {
        $pelanggan = Pelanggan::all();
        return view('penjualan.create', compact('pelanggan'));
    }

    /**
     * Store a newly created penjualan in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'TanggalPenjualan' => 'required|date',
            'PelangganID' => 'required|exists:pelanggan,PelangganID',
        ]);

        DB::statement("CALL InsertPenjualan(?, ?)", [
            $validated['TanggalPenjualan'],
            $validated['PelangganID']
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan.');
    }

    /**
     * Show the details of a specific penjualan.
     *
     * @param int $id
     * @return View
     */
    public function show($id): View
    {
        $penjualan = Penjualan::with('pelanggan')->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified penjualan.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $penjualan = Penjualan::findOrFail($id);
        $pelanggan = Pelanggan::all();
        return view('penjualan.edit', compact('penjualan', 'pelanggan'));
    }

    /**
     * Update the specified penjualan in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'TanggalPenjualan' => 'required|date',
            'TotalHarga' => 'required|numeric|min:0',
            'PelangganID' => 'required|exists:pelanggan,PelangganID',
        ]);

        // Update penjualan data tanpa store procedure
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->update($validated);

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui!');
    }

    /**
     * Remove the specified penjualan from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        DB::statement("CALL DeletePenjualan(?)", [$id]);

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus!');
    }

    /**
     * Export penjualan data to PDF.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPDF()
    {
        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan.produk'])->get();
    
        $pdf = PDF::loadView('penjualan.pdf', compact('penjualan'))
                ->setPaper('a4', 'landscape');
    
        return $pdf->download('laporan_penjualan.pdf');
    }
}