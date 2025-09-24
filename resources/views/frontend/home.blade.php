@extends('frontend.layouts.master')

@section('content')
<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center">
  <div class="container">
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> {{$message}}
    </div>
    @endif
    <div class="row">
      <div class="col-lg-6 d-flex flex-column justify-content-center">
        <h1 data-aos="fade-up">Selamat Datang di Daftar Hadir Rapat Online</h1>
        <h2 data-aos="fade-up" data-aos-delay="400">Aplikasi Daftar Hadir Rapat Online yang dapat diakses dimana saja</h2>
        <div data-aos="fade-up" data-aos-delay="600">
          <div class="text-center text-lg-start">
            <a href="{!! url('dashboard') !!}" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
              <span>Mulai </span>
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
        <img src="{{ asset('frontend/assets/img/hero-img.png') }}" class="img-fluid" alt="">
      </div>
    </div>
  </div>

</section><!-- End Hero -->

<main id="main">

  {{-- <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <h2>Cari</h2>
        <p>Cari Daftar Hadir dengan No</p>
      </header>

      <div class="row gy-4">



        <div class="col-lg-12">
          <form action="forms/contact.php" method="post" class="php-email-form">
            <div class="row gy-4">

              <div class="col-md-12">
                <input type="text" name="name" class="form-control" placeholder="Cth: 1234-5678-9011" required>
                <small><i>*https://daftar-hadir.bpip.go.id/lembar/<span style="color: red">1234-5678-9011</span></i></small>
              </div>

              <div class="col-md-12 text-center">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>

                <button type="submit">Cari</button>
              </div>

            </div>
          </form>

        </div>

      </div>

    </div>

  </section><!-- End Contact Section --> --}}

  <!-- ======= Values Section ======= -->
  <section id="values" class="values">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <h2>Fitur</h2>
        <p>Manfaat Daftar Hadir Online</p>
      </header>

      <div class="row">

        <div class="col-lg-4">
          <div class="box" data-aos="fade-up" data-aos-delay="200">
            <img src="{{ asset('frontend/assets/img/values-1.png') }}" class="img-fluid" alt="">
            <h3>Pembuatan Lembar Daftar Hadir</h3>
            <p>Seluruh Pegawai dapat membuat Lembar Daftar Hadir Online</p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="box" data-aos="fade-up" data-aos-delay="400">
            <img src="{{ asset('frontend/assets/img/values-2.png') }}" class="img-fluid" alt="">
            <h3>Akses dengan SSO-BPIP</h3>
            <p>Pengisian Daftar Hadir yang terkoneksi dengan SSO-BPIP</p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="box" data-aos="fade-up" data-aos-delay="600">
            <img src="{{ asset('frontend/assets/img/values-3.png') }}" class="img-fluid" alt="">
            <h3>Rekapitulasi Absen</h3>
            <p>Rekapitulasi Hasil Daftar Hadir yang telah dibuat</p>
          </div>
        </div>

      </div>

    </div>

  </section><!-- End Values Section -->

  <!-- ======= Counts Section ======= -->
  <section id="counts" class="counts">
    <div class="container" data-aos="fade-up">

      <div class="row gy-4">

        <div class="col-lg-3 col-md-6">
          <div class="count-box">
            <i class="bi bi-people"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="0" data-purecounter-duration="1" class="purecounter"></span>
              <p>Seluruh Peserta</p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="count-box">
            <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="0" data-purecounter-duration="1" class="purecounter"></span>
              <p>Lembar Daftar Hadir</p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="count-box">
            <i class="bi bi-headset" style="color: #15be56;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="0" data-purecounter-duration="1" class="purecounter"></span>
              <p>Satuan Kerja</p>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="count-box">
            <i class="bi bi-people" style="color: #bb0852;"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="0" data-purecounter-duration="1" class="purecounter"></span>
              <p>Akses Website</p>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Counts Section -->

</main><!-- End #main -->
@endsection
