@extends('frontend.layouts.master')

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->

    <style>
        .info-box {
            color: #444444;
            background: #fafbff;
            padding: 30px;
        }

        p {
            color: #444444;
        }
    </style>
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Daftar Hadir</h2>
                <p>Lembar Daftar Hadir</p>
            </header>
            <div class="col-md-12">
                <div class="info-box">
                    @if (Carbon\Carbon::parse($kegiatan->tgl_mulai)->toDateString() == Carbon\Carbon::parse($kegiatan->tgl_selesai)->toDateString())
                    <p> {{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->translatedformat('d F Y') }}|{{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->format('H:i').' - '.Carbon\Carbon::parse($kegiatan->tgl_selesai)->format('H:i')}} WIB</p>
                    @else
                    <p> {{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->translatedformat('d F Y H:i')}} WIB -{{ Carbon\Carbon::parse($kegiatan->tgl_selesai)->translatedformat('d F Y H:i')}} WIB</p>
                    @endif
                    <h3>{{ $kegiatan->judul_kegiatan }}</h3>
                    <p>Daftar hadir hanya dapat diisi ketika acara berlangsung</p>

                </div>
            </div>





            <div data-aos="fade-up" data-aos-delay="600">

            </div>
        </div>


    </section>
</main><!-- End #main -->
@endsection