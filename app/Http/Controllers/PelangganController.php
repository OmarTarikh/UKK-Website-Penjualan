<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    /**
     *
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'nullable|string',
            'NomorTelepon' => 'nullable|string|max:15',
        ]);

        Pelanggan::create($request->all());

        return redirect()->back()->with('success', 'Data Pelanggan berhasil ditambahkan!');
    }

    /**
     *
     */
    public function show($PelangganID)
    {
        $pelanggan = Pelanggan::findOrFail($PelangganID);
        return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     *
     */
    public function edit($PelangganID)
    {
        $pelanggan = Pelanggan::findOrFail($PelangganID);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     *
     */
    public function update(Request $request, $PelangganID)
    {
        $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'nullable|string',
            'NomorTelepon' => 'nullable|string|max:15',
        ]);

        $pelanggan = Pelanggan::findOrFail($PelangganID);
        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    /**
     * 
     */
    public function destroy($PelangganID)
    {
        $pelanggan = Pelanggan::findOrFail($PelangganID);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
