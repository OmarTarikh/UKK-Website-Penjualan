@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="m-0 font-weight-bold text-primary">Data Tabel Penjualan</h6>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-md btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addPenjualanModal">
                                        Tambah Penjualan
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#fff" d="M7.007 12a.75.75 0 0 1 .75-.75h3.493V7.757a.75.75 0 0 1 1.5 0v3.493h3.493a.75.75 0 1 1 0 1.5H12.75v3.493a.75.75 0 0 1-1.5 0V12.75H7.757a.75.75 0 0 1-.75-.75"/><path fill="#fff" fill-rule="evenodd" d="M7.317 3.769a42.5 42.5 0 0 1 9.366 0c1.827.204 3.302 1.643 3.516 3.48c.37 3.157.37 6.346 0 9.503c-.215 1.837-1.69 3.275-3.516 3.48a42.5 42.5 0 0 1-9.366 0c-1.827-.205-3.302-1.643-3.516-3.48a41 41 0 0 1 0-9.503c.214-1.837 1.69-3.276 3.516-3.48m9.2 1.49a41 41 0 0 0-9.034 0A2.486 2.486 0 0 0 5.29 7.424a39.4 39.4 0 0 0 0 9.154a2.486 2.486 0 0 0 2.193 2.164c2.977.332 6.057.332 9.034 0a2.486 2.486 0 0 0 2.192-2.164a39.4 39.4 0 0 0 0-9.154a2.486 2.486 0 0 0-2.192-2.163" clip-rule="evenodd"/></svg>
                                    </a>
                                    <a href="{{ route('penjualan.exportPDF') }}" class="btn btn-md btn-danger">
                                        Export to PDF
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="#fff" d="M13.586 2a2 2 0 0 1 1.284.467l.13.119L19.414 7a2 2 0 0 1 .578 1.238l.008.176V20a2 2 0 0 1-1.85 1.995L18 22H6a2 2 0 0 1-1.995-1.85L4 20V4a2 2 0 0 1 1.85-1.995L6 2zM12 4H6v16h12V10h-4.5a1.5 1.5 0 0 1-1.493-1.356L12 8.5zm.988 7.848a6.22 6.22 0 0 0 2.235 3.872c.887.717.076 2.121-.988 1.712a6.22 6.22 0 0 0-4.47 0c-1.065.41-1.876-.995-.989-1.712a6.22 6.22 0 0 0 2.235-3.872c.178-1.127 1.8-1.126 1.977 0m-.99 2.304l-.688 1.196h1.38zM14 4.414V8h3.586z"/></g></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="col">NO</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">TANGGAL PENJUALAN</th>
                                            <th scope="col">TOTAL HARGA</th>
                                            <th scope="col">PELANGGAN</th>
                                            <th scope="col">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penjualan as $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $p->PenjualanID }}</td>
                                            <td>{{ $p->TanggalPenjualan }}</td>
                                            <td>Rp {{ number_format($p->TotalHarga, 2, ',', '.') }}</td>
                                            <td>{{ $p->pelanggan->NamaPelanggan ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('penjualan.destroy', $p->PenjualanID) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                        
                                                    <!-- SHOW Button -->
                                                    <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#showPenjualanModal{{ $p->PenjualanID }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="#fff" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/></svg>
                                                    </button>
                                        
                                                    <!-- EDIT Button -->
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPenjualanModal{{ $p->PenjualanID }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></g></svg>
                                                    </button>
                                        
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24"><path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        
                                        <!-- SHOW Penjualan Modal -->
                                        <div class="modal fade" id="showPenjualanModal{{ $p->PenjualanID }}" tabindex="-1" aria-labelledby="showPenjualanLabel{{ $p->PenjualanID }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="showPenjualanLabel{{ $p->PenjualanID }}">Detail Penjualan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: none; color: gray; font-size: 20px;">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>ID Penjualan:</strong> {{ $p->PenjualanID }}</p>
                                                        <p><strong>Tanggal:</strong> {{ $p->TanggalPenjualan }}</p>
                                                        <p><strong>Total Harga:</strong> Rp {{ number_format($p->TotalHarga, 2, ',', '.') }}</p>
                                                        <p><strong>Pelanggan:</strong> {{ $p->pelanggan->NamaPelanggan ?? 'N/A' }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- EDIT Penjualan Modal -->
                                        <div class="modal fade" id="editPenjualanModal{{ $p->PenjualanID }}" tabindex="-1" aria-labelledby="editPenjualanLabel{{ $p->PenjualanID }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editPenjualanLabel{{ $p->PenjualanID }}">Edit Penjualan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: none; color: gray; font-size: 20px;">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('penjualan.update', $p->PenjualanID) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                        
                                                            <div class="mb-3">
                                                                <label for="editTanggalPenjualan{{ $p->PenjualanID }}" class="form-label">Tanggal Penjualan</label>
                                                                <input type="date" class="form-control" id="editTanggalPenjualan{{ $p->PenjualanID }}" name="TanggalPenjualan" value="{{ $p->TanggalPenjualan }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editTotalHarga{{ $p->PenjualanID }}" class="form-label">Total Harga</label>
                                                                <input type="number" class="form-control" id="editTotalHarga{{ $p->PenjualanID }}" name="TotalHarga" value="{{ $p->TotalHarga }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editPelangganID{{ $p->PenjualanID }}" class="form-label">Pilih Pelanggan</label>
                                                                <select class="form-select" id="editPelangganID{{ $p->PenjualanID }}" name="PelangganID" required>
                                                                    <option value="" disabled>Pilih Pelanggan</option>
                                                                    @foreach ($pelanggan as $pel)
                                                                        <option value="{{ $pel->PelangganID }}" {{ $p->PelangganID == $pel->PelangganID ? 'selected' : '' }}>
                                                                            {{ $pel->NamaPelanggan }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                    <!-- ADD Penjualan Modal -->
                    <div class="modal fade" id="addPenjualanModal" tabindex="-1" aria-labelledby="addPenjualanModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPenjualanModalLabel">Tambah Penjualan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: none; color: gray; font-size: 20px;">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form to add penjualan -->
                                    <form action="{{ route('penjualan.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="TanggalPenjualan" class="form-label">Tanggal Penjualan</label>
                                            <input type="date" class="form-control" id="TanggalPenjualan" name="TanggalPenjualan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="TotalHarga" class="form-label">Total Harga</label>
                                            <input type="number" class="form-control" id="TotalHarga" name="TotalHarga" value="0" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="PelangganID" class="form-label">Pilih Pelanggan</label>
                                            <select class="form-select" id="PelangganID" name="PelangganID" required>
                                                <option value="" disabled selected>Pilih Pelanggan</option>
                                                @foreach ($pelanggan as $p)
                                                    <option value="{{ $p->PelangganID }}">{{ $p->NamaPelanggan }}</option>
                                                @endforeach
                                            </select>
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
            <!-- End of Main Content -->
            <script>
                function updateTotalHarga(penjualanID) {
                    fetch(`/get-total-harga/${penjualanID}`)
                        .then(response => response.json())
                        .then(data => {
                            // Update TotalHarga in Edit Form
                            let totalHargaInput = document.getElementById(`editTotalHarga${penjualanID}`);
                            if (totalHargaInput) {
                                totalHargaInput.value = data.total_harga;
                            }
            
                            // Update TotalHarga in Table
                            let totalHargaDisplay = document.getElementById(`TotalHarga_${penjualanID}`);
                            if (totalHargaDisplay) {
                                totalHargaDisplay.innerText = 'Rp ' + data.total_harga.toLocaleString('id-ID', { minimumFractionDigits: 2 });
                            }
                        });
                }
            </script>        
@endsection