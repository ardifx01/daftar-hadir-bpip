@extends('frontend.layouts.master')

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.html">Beranda</a></li>
          <li>Cari</li>
        </ol>
        <h2>Cari Daftar Hadir</h2>

      </div>
    </section><!-- End Breadcrumbs -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <header class="section-header">
              <h2>Daftar Hadir</h2>
              <p>Cari Daftar Hadir dengan Nomor</p>
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
    </section>


  </main><!-- End #main -->
@endsection
