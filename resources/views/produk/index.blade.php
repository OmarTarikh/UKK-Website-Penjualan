@extends('layouts.app')

@section('title', 'Data Produk')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Tabel Produk</h6>
                <a href="#" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#addProdukModal">
                    Tambah Produk
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#fff" d="M7.007 12a.75.75 0 0 1 .75-.75h3.493V7.757a.75.75 0 0 1 1.5 0v3.493h3.493a.75.75 0 1 1 0 1.5H12.75v3.493a.75.75 0 0 1-1.5 0V12.75H7.757a.75.75 0 0 1-.75-.75"/>
                        <path fill="#fff" fill-rule="evenodd" d="M7.317 3.769a42.5 42.5 0 0 1 9.366 0c1.827.204 3.302 1.643 3.516 3.48c.37 3.157.37 6.346 0 9.503c-.215 1.837-1.69 3.275-3.516 3.48a42.5 42.5 0 0 1-9.366 0c-1.827-.205-3.302-1.643-3.516-3.48a41 41 0 0 1 0-9.503c.214-1.837 1.69-3.276 3.516-3.48m9.2 1.49a41 41 0 0 0-9.034 0A2.486 2.486 0 0 0 5.29 7.424a39.4 39.4 0 0 0 0 9.154a2.486 2.486 0 0 0 2.193 2.164c2.977.332 6.057.332 9.034 0a2.486 2.486 0 0 0 2.192-2.164a39.4 39.4 0 0 0 0-9.154a2.486 2.486 0 0 0-2.192-2.163" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID</th>
                            <th>NAMA PRODUK</th>
                            <th>HARGA</th>
                            <th>STOK</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produk as $p)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $p->ProdukID }}</td>
                            <td>{{ $p->NamaProduk }}</td>
                            <td>Rp {{ number_format($p->Harga, 2, ',', '.') }}</td>
                            <td>{{ $p->Stok }}</td>
                            <td class="text-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('produk.destroy', $p->ProdukID) }}" method="POST">
                                    
                                    <!-- SHOW BUTTON -->
                                    <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#showProdukModal{{ $p->ProdukID }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="#fff" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg>
                                    </button>
    
                                    <!-- EDIT BUTTON -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProdukModal{{ $p->ProdukID }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></g></svg>
                                    </button>
    
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24"><path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="alert alert-danger">Data Produk belum tersedia.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @foreach ($produk as $p)
        <!-- SHOW Produk Modal -->
        <div class="modal fade" id="showProdukModal{{ $p->ProdukID }}" tabindex="-1" aria-labelledby="showProdukLabel{{ $p->ProdukID }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showProdukLabel{{ $p->ProdukID }}">Detail Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: none; color: gray; font-size: 20px;">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama Produk:</strong> {{ $p->NamaProduk }}</p>
                        <p><strong>Harga:</strong> Rp {{ number_format($p->Harga, 2, ',', '.') }}</p>
                        <p><strong>Stok:</strong> {{ $p->Stok }}</p>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT Produk Modal -->
        <div class="modal fade" id="editProdukModal{{ $p->ProdukID }}" tabindex="-1" aria-labelledby="editProdukLabel{{ $p->ProdukID }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProdukLabel{{ $p->ProdukID }}">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: none; color: gray; font-size: 20px;">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('produk.update', $p->ProdukID) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="NamaProduk{{ $p->ProdukID }}" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="NamaProduk{{ $p->ProdukID }}" name="NamaProduk" value="{{ $p->NamaProduk }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="Harga{{ $p->ProdukID }}" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="Harga{{ $p->ProdukID }}" name="Harga" value="{{ $p->Harga }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="Stok{{ $p->ProdukID }}" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="Stok{{ $p->ProdukID }}" name="Stok" value="{{ $p->Stok }}" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Tambah Produk Modal -->
    <div class="modal fade" id="addProdukModal" tabindex="-1" aria-labelledby="addProdukLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProdukLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: none; color: gray; font-size: 20px;">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to add Produk -->
                    <form action="{{ route('produk.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="NamaProduk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" required>
                        </div>
                        <div class="mb-3">
                            <label for="Harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="Harga" name="Harga" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="Stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="Stok" name="Stok" min="0" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

@endsection