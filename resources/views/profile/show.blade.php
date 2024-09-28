@extends('layout.main')

@section('title', 'Profile')

@section('subtitle', 'User Profile')
@section('home', 'Profile')
@section('page', 'Pengguna')

@section('kont')
<style>
    .card-warning.card-outline {
        border-top: 3px solid #ffc107;
    }
    .card-header {
        background-color: #ffc107;
    }
    .btn-warning {
        color: #fff;
        background-color: #ffc107;
        border-color: #ffc107;
    }
    .btn-warning:hover {
        color: #fff;
        background-color: #e0a800;
        border-color: #d39e00;
    }
    .input-group-text {
        background-color: #ffc107;
        border-color: #ffc107;
    }
    .form-control {
        border-color: #ffc107;
    }
    .form-control:focus {
        border-color: #e0a800;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }
</style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Profile Section -->
                <div class="card card-warning card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('dist/img/user4-128x128.jpg') }}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                        <p class="text-muted text-center">{{ Auth::user()->role ?? 'Software Engineer' }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Username</b> <a class="float-right">{{ Auth::user()->username ?? 0 }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Alamat</b> <a class="float-right">{{ Auth::user()->address ?? 0 }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>No Telp</b> <a class="float-right">{{ Auth::user()->phone_number ?? 0 }}</a>
                            </li>
                        </ul>

                        <a href="{{ route('logout') }}" class="btn btn-warning btn-block"><b>Keluar</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- Tabs for Edit Profile and Change Password -->
                <div class="card mt-4">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="javascript::void()" id="updateProfile" data-toggle="tab">Perbarui Profil</a></li>
                            <li class="nav-item"><a class="nav-link" href="javascript::void()" id="changePassword" data-toggle="tab">Ganti Kata Sandi</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Update Profile Section -->
                            <div class="active tab-pane tab-updateProfile" >
                                <form method="POST" action="{{ route('profile.update', Auth::user()->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ Auth::user()->name }}" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="username" id="username" class="form-control"
                                                value="{{ Auth::user()->username }}" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Alamat</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="address" id="address" class="form-control"
                                                value="{{ Auth::user()->address }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-map-marker-alt"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone_number">No Telp</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="phone_number" id="phone_number" class="form-control"
                                                value="{{ Auth::user()->phone_number }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-phone"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="profile_photo">Foto Profil</label>
                                        <input type="file" name="profile_photo" id="profile_photo"
                                            class="form-control-file">
                                    </div>

                                    <button type="submit" class="btn btn-warning btn-block">Perbarui Profil</button>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- Change Password Section -->
                            <div class="tab-pane tab-changePassword" >
                                <form method="POST" action="{{ route('profile.change-password', Auth::user()->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="new_password">Kata Sandi Baru</label>
                                        <div class="input-group mb-3">
                                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password_confirmation">Konfirmasi Kata Sandi Baru</label>
                                        <div class="input-group mb-3">
                                            <input type="password" name="new_password_confirmation"
                                                id="new_password_confirmation" class="form-control" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-warning btn-block">Ganti Kata Sandi</button>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#updateProfile').click(function (e) { 
                e.preventDefault();
                $('.tab-updateProfile').addClass('active');
                $('.tab-changePassword').removeClass('active');
            });

            $('#changePassword').click(function (e) { 
                e.preventDefault();
                $('.tab-changePassword').addClass('active');
                $('.tab-updateProfile').removeClass('active');
            });
        });
    </script>
@endpush
