@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Statistik Jumlah Data -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Barang</h5>
                    <h2>{{$barang}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Ruangan</h5>
                    <h2>{{$ruangan}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Anggota</h5>
                    <h2>{{$anggota}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Kategori</h5>
                    <h2>{{$kategori}}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Penggunaan Barang -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Penggunaan Barang</h5>
                </div>
                <div class="card-body">
                    <!-- Grafik Penggunaan Barang (Bar Chart) -->
                    <div id="bar-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Barang Per Kategori</h5>
                </div>
                <div class="card-body">
                    <!-- Grafik Barang Per Kategori (Pie Chart) -->
                    <div id="pie-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Aktivitas Terkini -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Aktivitas Terkini</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Aksi</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Barang -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Daftar Barang</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Include Chart.js or other libraries for graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Example Bar Chart for Usage
    var ctxBar = document.getElementById('bar-chart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Barang 1', 'Barang 2', 'Barang 3'],
            datasets: [{
                label: 'Jumlah Penggunaan',
                data: [12, 19, 3],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Example Pie Chart for Categories
    var ctxPie = document.getElementById('pie-chart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Kategori 1', 'Kategori 2', 'Kategori 3'],
            datasets: [{
                data: [10, 20, 30],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        }
    });
</script>
@endpush
