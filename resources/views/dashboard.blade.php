@extends('layout.main')

@section('title', 'Dashboard')

@section('subtitle', 'Dashboard Overview')

@section('kont')

<style>
 .card-body.box-profile {
    position: relative;
    text-align: center;
}

.profile-header {
    display: flex;
    align-items: left;
    justify-content: left;
    background-color: #dc3545; /* Red background */
    padding: 15px; /* Padding inside the background */
    border-radius: 10px; /* Optional: round corners */
    margin-bottom: 5px; /* Space below the profile header */
    position: relative; /* Make sure it's relative for the icon positioning */
}

.profile-header .background-icon {
    position: absolute;
    top: 50%;
    left: 80%;
    transform: translate(-50%, -50%);
    font-size: 100px; /* Adjust size as needed */
    color: rgba(17, 11, 11, 0.3); /* White color with 50% opacity */
    z-index: 0; /* Make sure it's behind other content */
}

.profile-header img {
    width: 130px;
    height: 130px;
    margin-right: 15px; /* Space between the photo and the name */
    z-index: 1; /* Ensure it is above the background icon */
}

.profile-info {
    text-align: left;
    color: #fff; /* White text color for the name */
    z-index: 1; /* Ensure it is above the background icon */
}

.profile-info h3 {
    margin: 0;
    font-size: 2em;
}

.profile-info p {
    margin: 0;
    font-size: 1.2em;
    color: #ffc107; /* Yellow text color for the class */
}

ul.list-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0;
    margin: 0;
}

ul.list-group .list-group-item {
    border: none;
    background: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 1.5em;
    margin: 0;
    padding: 0;
}

ul.list-group .list-group-item b {
    margin-top: 0; /* Space between number and label */
    font-size: 1.2em;
}

ul.list-group .list-group-item a {
    font-size: 3em; /* Size for the violation number */
    color: #dc3545; /* Red color for the number */
    font-weight: bold;
}


</style>
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="jumlah-pelanggaran">Loading...</h3>
                        <p>Pelanggaran</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                        <a href="{{ url('laporan/pelanggaran') }}" class="small-box-footer">Informasi lebih lanjut <i
                                class="fas fa-arrow-circle-right"></i></a>
                    @endif
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="jumlah-perizinan">Loading...</h3>
                        <p>Perizinan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                        <a href="{{ route('permissions.index') }}" class="small-box-footer">Informasi lebih lanjut <i
                                class="fas fa-arrow-circle-right"></i></a>
                    @endif
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="jumlah-santri">Loading...</h3>
                        <p>Santri</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                        <a href="{{ url('santri') }}" class="small-box-footer">Informasi lebih lanjut <i
                                class="fas fa-arrow-circle-right"></i></a>
                    @endif
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3 id="jumlah-pengguna">Loading...</h3>
                        <p>Pengguna</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                        <a href="{{ url('users') }}" class="small-box-footer">Informasi lebih lanjut <i
                                class="fas fa-arrow-circle-right"></i></a>
                    @endif
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <!-- BAR CHART -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Bar Pelanggaran Dan Perizinan Tahun ini</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.left col -->

            <!-- Right col -->
            <section class="col-lg-6 connectedSortable">
                <!-- USERS LIST -->
                
                <!--/.card -->
                <div class="card card-danger ">
                    <div class="card-header bg-danger color-palette">
                        <h3 class="card-title">Santri Paling Bermasalah</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body box-profile">
                        <div class="profile-header">
                            <div class="background-icon">
                                <i class="fas fa-gavel"></i>
                            </div>
                            <img class="" id="top-santri-foto"
                                src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                            <div class="profile-info">
                                <h3 class="profile-username" id="top-santri-nama">Loading...</h3>
                                <p class="text" id="top-santri-kelas">Loading...</p>
                            </div>
                        </div>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <a class="text-danger text-bold" id="top-santri-total">Loading...</a>
                                <b>Pelanggaran</b>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        <section class="col-lg-6 connectedSortable">
                <div class="card bg-navy">
                    <div class="card-header bg-navy color-palette">
                        <h3 class="card-title">Top 8 Santri Pelanggaran Terbanyak</h3>
                        <div class="card-tools">
                            <span class="badge badge-danger">8 Santri</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0 bg-navy disabled color-palette">
                        <ul class="users-list clearfix" id="top-santri-list">
                            <!-- List will be populated by JavaScript -->
                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ url('santri') }}">Lihat Semua Santri</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                
            </section>
                    
                    
                    
                
       
            <!-- /.right col -->
            
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch Pelanggaran data
            fetch('/dashboard/data')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('jumlah-pelanggaran').innerText = data.jumlahPelanggaran;
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                });

            // Fetch Perizinan data
            fetch('/dashboard/data-permission')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('jumlah-perizinan').innerText = data.jumlahPerizinan;
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                });

            // Fetch Pengguna data
            fetch('/dashboard/data-user')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('jumlah-pengguna').innerText = data.jumlahPengguna;
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                });

            // Fetch Santri data
            fetch('/dashboard/data-santri')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('jumlah-santri').innerText = data.jumlahSantri;
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                });

           // Fetch data for Bar Chart
fetch('/dashboard/data-bar')
    .then(response => response.json())
    .then(data => {
        var ctx = document.getElementById('barChart').getContext('2d');

        // Define gradient for the background colors
        var gradientPelanggaran = ctx.createLinearGradient(0, 0, 0, 400);
        gradientPelanggaran.addColorStop(0, 'rgba(255, 99, 132, 0.7)');
        gradientPelanggaran.addColorStop(1, 'rgba(255, 99, 132, 0.2)');

        var gradientPerizinan = ctx.createLinearGradient(0, 0, 0, 400);
        gradientPerizinan.addColorStop(0, 'rgba(54, 162, 235, 0.7)');
        gradientPerizinan.addColorStop(1, 'rgba(54, 162, 235, 0.2)');

        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                        label: 'Pelanggaran',
                        data: data.pelanggaran,
                        backgroundColor: gradientPelanggaran,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.9)',
                        hoverBorderColor: 'rgba(255, 99, 132, 1)'
                    },
                    {
                        label: 'Perizinan',
                        data: data.perizinan,
                        backgroundColor: gradientPerizinan,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)',
                        hoverBorderColor: 'rgba(54, 162, 235, 1)'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching bar chart data:', error);
    });


            // Fetch top santri data
            fetch('/dashboard/top-santri')
                .then(response => response.json())
                .then(data => {
                    const topSantriList = document.getElementById('top-santri-list');
                    topSantriList.innerHTML = data.map(santri => `
                        <li>
                            <img src="/images/${santri.foto}" alt="${santri.nama}" class="img-circle" style="width: 70px; height: 70px;">
                            <a class="users-list-name text-light" href="#">${santri.nama}</a>
                            <span class="users-list-date">${santri.total} Pelanggaran</span>
                        </li>
                    `).join('');

                    // Populate top 1 santri card
                    const topSantri = data[0];
                    if (topSantri) {
                        document.getElementById('top-santri-foto').src = `/images/${topSantri.foto}`;
                        document.getElementById('top-santri-nama').innerText = topSantri.nama;
                        document.getElementById('top-santri-kelas').innerText = topSantri.kelas;
                        document.getElementById('top-santri-total').innerText = `${topSantri.total}`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching top santri data:', error);
                });
        });

        document.addEventListener("DOMContentLoaded", function() {
            fetch('/dashboard/top-troublesome-santri') // Ganti dengan endpoint yang sesuai untuk top santri ternakal
                .then(response => response.json())
                .then(data => {
                    document.getElementById('top-santri-nama').innerText = data.nama;
                    document.getElementById('top-santri-foto').src = `/images/${data.foto}`;
                    document.getElementById('top-santri-pelanggaran').innerText = data.jumlahPelanggaran;
                    document.getElementById('top-santri-perizinan').innerText = data.jumlahPerizinan;
                    document.getElementById('top-santri-total').innerText = data.totalPelanggaranPerizinan;
                })
                .catch(error => {
                    console.error('Error fetching top troublesome santri data:', error);
                });
        });
    </script>
@endsection
