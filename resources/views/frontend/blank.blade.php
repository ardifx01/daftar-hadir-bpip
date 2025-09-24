@extends('frontend.layouts.master')

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.html">Beranda</a></li>
          <li>Blank</li>
        </ol>
        <h2>Blank Template</h2>

      </div>
    </section><!-- End Breadcrumbs -->
    <style>
        .info-box{
            color: #444444;
            background: #fafbff;
            padding: 30px;
        }
    </style>
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <header class="section-header">
              <h2>Daftar Hadir</h2>
              <p>Lembar Daftar Hadir - Eksternal</p>
            </header>

            <div class="row gy-4">

              <div class="col-lg-4">

                <div class="row gy-4">
                  <div class="col-md-12">
                    <div class="info-box">
                        <i class="bi bi-pencil"></i>
                        <h3>Judul</h3>
                        <p>simply dummy text of the printing and typesetting industry.</p>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="info-box">
                      <i class="bi bi-envelope-open"></i>
                      <h3>Undangan</h3>
                      <p><a href="#">File Undangan</a></p>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="info-box">
                      <i class="bi bi-geo-alt"></i>
                      <h3>Tempat</h3>
                      <p>Zoom Meeting : 33333; Password: 123123</p>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="info-box">
                      <i class="bi bi-clock"></i>
                      <h3>Waktu</h3>
                      <p>12-Okt-2021<br>16:30 - 17:30 WIB</p>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="info-box">
                      <i class="bi bi-download"></i>
                      <h3>Materi</h3>
                      <p> <a href='#'>1. Materi A</a>
                          <br><a href='#'>2. Materi B</a>
                          <br><a href='#'>3. Materi C</a>
                      </p>
                    </div>
                  </div>

                </div>

              </div>

              <div class="col-lg-8">
                <form action="forms/contact.php" method="post" class="php-email-form">
                  <div class="row gy-4">

                    <div class="col-md-6">
                      <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                    </div>

                    <div class="col-md-6 ">
                      <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                    </div>

                    <div class="col-md-12">
                      <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                    </div>

                    <div class="col-md-12">
                      <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                    </div>

                    <div class="col-md-12 text-center">
                      <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>

                  </div>
                </form>

              </div>

            </div>

          </div>
    </section>

  </main><!-- End #main -->
@endsection
