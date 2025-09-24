<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') &mdash; Daftar Hadir</title>

  <link rel="shortcut icon" href="https://siatapv2.bpip.go.id/favicon.ico" type="image/x-icon">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}"> --}}
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />


</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
          </div>
        </form>
        <ul class="navbar-nav navbar-right">

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="{{ asset('backend/assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::check() ? Auth::user()->name : 'User' }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">{{  Auth::user()->satuan_kerja }}</div>

              <div class="dropdown-divider"></div>
              <a href="{!! url('logout') !!}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#">Daftar Hadir - BPIP</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">DH</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Daftar Hadir-ku</li>
            <li {{{ (Request::path()=='dashboard' ? 'class=active' : '') }}}>
              <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li {{{ (Request::path()=='kegiatan' ? 'class=active' : '') }}}>
              <a class="nav-link" href="{{ route('kegiatan') }}"><i class="fas fa-clipboard-list"></i> <span>DH Kegiatan-ku</span></a>
            </li>
            {{-- <li {{{ (Request::path()=='narasumber' ? 'class=active' : '') }}}>
              <a class="nav-link" href="/narasumber"><i class="fas fa-file-signature"></i> <span>DH Narasumber</span></a>
            </li> --}}
            <li {{{ (Request::path()=='list-daftar-hadir' ? 'class=active' : '') }}}>
              <a class="nav-link" href="{{ route('list-daftar-hadir') }}"><i class="fas fa-clipboard-check"></i> <span>List Daftar Hadir</span></a>
            </li>
            <!--
            <li class="menu-header">Admin Daftar Hadir</li>
            <li {{{ (Request::path()=='dashboard-admin' ? 'class=active' : '') }}}>
              <a class="nav-link" href="/dashboard-admin"><i class="fas fa-tachometer-alt"></i> <span>Dashboard Admin</span></a>
            </li>
            <li {{{ (Request::path()=='list-daftar-hadir-all' ? 'class=active' : '') }}}>
              <a class="nav-link" href="/list-daftar-hadir-all"><i class="fas fa-clipboard-check"></i> <span>List Daftar Hadir</span></a>
            </li>
            <li {{{ (Request::path()=='peserta-eksternal' ? 'class=active' : '') }}}>
              <a class="nav-link" href="/peserta-eksternal"><i class="fas fa-users"></i> <span>Peserta Eksternal</span></a>
            </li>
            <li {{{ (Request::path()=='role' ? 'class=active' : '') }}}>
              <a class="nav-link" href="/role"><i class="fas fa-lock"></i> <span>Role</span></a>
            </li>
            -->
            @php
                use App\Http\Classes\AuthSSO;
                $token = AuthSSO::getSessionToken();
                $roleData = Cache::get($token . '#roleUserIntra');


            @endphp

            @if ($roleData != null)
            <!-- Pengelola Pusat dan Pengelola Satuan Kerja -->
            <li class="menu-header">Pengelola Daftar Hadir</li>
            {{-- <li {{{ (Request::path()=='admin-dashboard' ? 'class=active' : '') }}}>
                <a class="nav-link" href="{{ route('admin-daftar-hadir.index') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li> --}}
            <li {{{ (Request::path()=='admin-list-all' ? 'class=active' : '') }}}>
                <a class="nav-link" href="{{ route('admin-daftar-hadir.list-all') }}"><i class="fas fa-tachometer-alt"></i> <span>Daftar Hadir All</span></a>
            </li>
            @endif
          </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="/" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Halaman Depan
              </a>
            </div>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <footer class="main-footer">
        <div class="footer-left">
            2022 - {{ date('Y')}} &copy; Copyright - <strong><span>Badan Pengelolaan Ideologi Pancasila</span></strong>. All Rights Reserved
          <div class="bullet"></div>  Powered by <a href='https://brin.go.id'>Badan Riset dan Inovasi Nasional</a> | Design By Template <a href="https://getstisla.com/">Stisla</a>
        </div>
        <div class="footer-right">

        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  {{-- <script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script> --}}
  <script src="{{ asset('backend/assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
  {{-- <script src="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}" type="text/javascript"></script> --}}
  <script src="{{ asset('backend/assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.js')}}" type="text/javascript"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
  <!-- <script src="{{ asset('backend/assets/modules/select2/dist/js/select2.js')}}" type="text/javascript"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="{{ asset('backend/assets/modules/sweetalert/sweetalert.min.js')}}" type="text/javascript">

  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
  @stack('scripts')
</body>

</html>
