<nav id="navbar" class="navbar">
  <ul>
    <li><a class="nav-link scrollto active" href="{!! url('/') !!}">Beranda</a></li>
    <!-- temporarily hidden until ready -->
    <!-- <li><a class="nav-link scrollto" href="/cari">Cari</a></li> -->
    <!-- <li><a class="nav-link scrollto" href="/blank">Tentang</a></li>  -->
    @login
    <a class="nav-link scrollto active" href="{!! url('dashboard') !!}">Admin</a>


    <a href="{!! url('logout') !!}" class="nav-link scrollto text-danger">
      Logout
    </a>
    </div>
    @else

    <li><a class="nav-link scrollto active" href="{!! url('login/sso') !!}">Login</a></li>

    @endlogin
  </ul>
  <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->
