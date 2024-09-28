<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{csrf_token()}}">
  
  <title>Sistem Informasi Manajemen | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assetadmin')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('assetadmin')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assetadmin')}}/dist/css/adminlte.min.css">

  <style>
    body {
      background: url('{{ asset("assetadmin") }}/img/masjid.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .login-box {
      background: rgba(255, 255, 255, 0.9); /* Adjusted opacity */
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 500px; /* Ensure it doesn't exceed 500px */
      margin: 900px;
    }
    .logo {
      width: 80px; /* Adjust the width as needed */
      margin-bottom: 20px; /* Add some margin below the logo */
    }
    .login-card-body {
      padding: 20px;
    }
    @media (max-width: 768px) {
      .login-box {
        padding: 15px;
        border-radius: 8px;
      }
      .login-card-body {
        padding: 15px;
      }
    }
    @media (max-width: 576px) {
      .logo {
        width: 60px; /* Smaller logo for smaller screens */
        margin-bottom: 15px;
      }
      .login-box {
        padding: 10px;
        border-radius: 5px;
      }
      .login-card-body {
        padding: 10px;
      }
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-warning">
    <div class="card-header text-center">
      <img src="{{ asset('assetadmin/img/logo.png') }}" alt="Logo" class="logo">
      <h2><b>PENGURUS KEAMANAN</b></h2>
      <h5>Sistem Perizinan dan Organisir Ta'zir</h5>
      <h4>Pondok Pesantren Salafiyah Sholawat</h4>
    </div>
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masuk untuk memulai sesi</p>

      <form action="{{ url('login/proses') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <div class="invalid-feedback">
            @error('username') {{$message}} @enderror
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="invalid-feedback">
            @error('password') {{$message}} @enderror
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-warning btn-block">Masuk Sistem</button>
          </div>
        </div>
      </form>
      
     
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="{{asset('assetadmin')}}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assetadmin')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('assetadmin')}}/dist/js/adminlte.min.js"></script>
</body>
</html>
