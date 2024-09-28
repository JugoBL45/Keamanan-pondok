<aside class="main-sidebar elevation-4 sidebar-dark-olive">
    <!-- Brand Logo -->
    <a href="{{ url('dashboard') }}" class="brand-link bg-warning">
        <img src="{{ asset('assetadmin') }}/dist/img/logoSholawat.png" alt="LogoSholawat" class="brand-image" style="opacity: 1">
        <span class="brand-text font-weight-bold">Keamanan PP</span>
    </a>

    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img id="profilePhoto" src="{{ Auth::user()->profile_photo_url }}" class="img-circle elevation-2 bg-olive" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar sidebar-fixed flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item mt-2">
                    <a href="{{ url('dashboard') }}" class="nav-link font-weight-bold bg-warning">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(Auth::user()->role == 1)
                <!-- Master Data Menu for Role 1 -->
                <li class="nav-item mt-2">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Master Data <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('master_pelanggaran') }}" class="nav-link">
                                <i class="fas fa-exclamation-triangle nav-icon"></i>
                                <p>Master Pelanggaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('master_level') }}" class="nav-link">
                                <i class="fas fa-layer-group nav-icon"></i>
                                <p>Master Level</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('kelas') }}" class="nav-link">
                                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                                <p>Master Kelas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                <!-- Sistem Title -->
                <li class="nav-header text-uppercase font-weight-bold mt-2 mb-1">Sistem</li>
                <hr style="border-color: #6c757d; margin: 0 1.25rem;">

                <!-- Sistem Menu -->
                <li class="nav-item mt-2">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Perizinan <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('permissions.index') }}" class="nav-link">
                                <i class="fas fa-user-check nav-icon"></i>
                                <p>Perizinan Santri</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Ta'zir Santri Menu -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-gavel"></i>
                        <p>Ta'zir Santri <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/pelanggaran/input') }}" class="nav-link">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Tambah Pelanggaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/pelanggaran/harian') }}" class="nav-link">
                                <i class="fas fa-calendar-day nav-icon"></i>
                                <p>Harian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/pelanggaran/bulanan') }}" class="nav-link">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p>Bulanan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                <!-- Laporan Menu -->
                <li class="nav-item mt-2">
                    <a href="{{ url('laporan/pelanggaran') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan </p>
                    </a>
                </li>
                @endif

                @if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3)
                <!-- User Title -->
                <li class="nav-header text-uppercase font-weight-bold mt-4 mb-1">Manajemen User</li>
                <hr style="border-color: #6c757d; margin: 0 1.25rem;">

                <!-- SDM Menu -->
                <li class="nav-item mt-2">
                    <a href="{{ url('santri') }}" class="nav-link">
                        <i class="fas fa-user-friends nav-icon"></i>
                        <p>Santri</p>
                    </a>
                </li>
                @if(Auth::user()->role == 1)
                <li class="nav-item mt-2">
                    <a href="{{ url('users') }}" class="nav-link">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Pengguna</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ url('/users/activity-logs') }}" class="nav-link">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Log Aktivitas</p>
                    </a>
                </li>
                @endif
                @endif

                <!-- Logout Menu -->
                <li class="nav-item mt-2">
                    {{-- <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a> --}}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Include jQuery if not already included -->
<script src="{{ asset('assetadmin') }}/plugins/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Check if profile photo fails to load
        $('#profilePhoto').on('error', function() {
            // Logout if the image fails to load
            window.location.href = "{{ route('logout') }}";
        });

        $('.nav-link').on('click', function() {
            // Remove active class from all links
            $('.nav-link').removeClass('active');

            // Add active class to the clicked link
            $(this).addClass('active');
        });
    });
</script>
