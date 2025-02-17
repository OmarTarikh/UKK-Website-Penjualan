@extends('layouts.app')

@section('title', 'Dashboard')
                
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
                    
    <!-- Content Row -->
    <div class="row">
                    
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pelanggan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pelanggan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                                                                
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Penjualan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penjualan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                                                                
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Produk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $produk }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- Content Row -->
                    
<div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Line chart Produk Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Filter Data:</div>
                            <a class="dropdown-item" href="#">Last 7 Days</a>
                            <a class="dropdown-item" href="#">Last 30 Days</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">All Time</a>
                        </div>
                    </div>
                </div>                      
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="produkAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>          
        <!-- Doughnut Chart Section -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Doughnut Chart Produk Overview</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="produkPieChart"></canvas> <!-- Updated Chart -->
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Total Produk
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Total Stok
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Total Terjual
                        </span>
                    </div>
                </div>
            </div>
        </div>
</div>

</div>
<!-- /.container-fluid -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
            
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var totalProduk = {{ $produk ?? 0 }};
                        var totalStok = {{ $totalStok ?? 0 }};
                        var totalPengeluaran = {{ $totalPengeluaran ?? 0 }};
                
                        var ctx = document.getElementById("produkPieChart").getContext('2d');
                
                        var produkPieChart = new Chart(ctx, {
                            type: 'doughnut', 
                            data: {
                                labels: [
                                    `Total Produk: ${totalProduk}`, 
                                    `Total Stok: ${totalStok}`, 
                                    `Total Sold: ${totalPengeluaran}`
                                ],
                                datasets: [{
                                    data: [totalProduk, totalStok, totalPengeluaran],
                                    backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
                                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#d9534f'],
                                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                                }],
                            },
                            options: {
                                maintainAspectRatio: false,
                                cutout: '60%', // Controls doughnut hole size
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    datalabels: {
                                        color: '#fff',
                                        font: {
                                            weight: 'bold',
                                            size: 14
                                        },
                                        formatter: (value, context) => {
                                            return value; // Display numbers inside slices
                                        }
                                    }
                                }
                            },
                            plugins: [ChartDataLabels] // Enable Data Labels Plugin
                        });
                    });
                </script>   

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var totalProduk = {{ $produk ?? 0 }}; // Added Total Produk
                        var totalStok = {{ $totalStok ?? 0 }};
                        var totalPengeluaran = {{ $totalPengeluaran ?? 0 }};

                        var ctxLine = document.getElementById("produkAreaChart").getContext('2d');

                        var produkAreaChart = new Chart(ctxLine, {
                            type: 'line',
                            data: {
                                labels: ["Total Produk", "Total Stok", "Total Pengeluaran (Sold)"], // Removed Pemasukan Stok
                                datasets: [{
                                    label: "Jumlah Stok",
                                    data: [totalProduk, totalStok, totalPengeluaran], // Removed Pemasukan Stok
                                    backgroundColor: "rgba(78, 115, 223, 0.2)",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointBorderColor: "rgba(255, 255, 255, 1)",
                                    pointHoverBackgroundColor: "rgba(255, 255, 255, 1)",
                                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                    borderWidth: 2,
                                    tension: 0.3 // Smooth curve
                                }],
                            },
                            options: {
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        grid: { display: false }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        grid: { color: "rgba(234, 236, 244, 1)" }
                                    }
                                },
                                plugins: {
                                    legend: { display: true }
                                }
                            }
                        });
                    });
                </script>
@endsection