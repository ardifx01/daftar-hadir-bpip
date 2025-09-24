@extends('frontend.layouts.master')

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->


    <section id="hero" class="hero d-flex align-items-center">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Daftar Hadir</h2>
                <p>Lembar Daftar Hadir</p>
            </header>
            <div class="col-md-12">
                <div class="info-box">
                    @if (Carbon\Carbon::parse($kegiatan->tgl_mulai)->toDateString() == Carbon\Carbon::parse($kegiatan->tgl_selesai)->toDateString())
                    <p style="color:blue ;font-weight: bold"> {{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->translatedformat('d F Y') }}|{{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->format('H:i').' - '.Carbon\Carbon::parse($kegiatan->tgl_selesai)->format('H:i')}} WIB</p>
                    @else
                    <p style="color:blue ;font-weight: bold"> {{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->translatedformat('d F Y H:i')}} WIB -{{ Carbon\Carbon::parse($kegiatan->tgl_selesai)->translatedformat('d F Y H:i')}} WIB</p>
                    @endif
                    <h3 style="color:#062d75 ;font-weight: bold;">{{ $kegiatan->judul_kegiatan }}</h3>
                    @if($kegiatan->jenis_kegiatan=='internal')
                    <p>Acara ini hanya untuk internal sivitas BPIP</p>


                    @login
                    <div class="clearfix"><br></div>
                    <a href="{{ route('isi-kehadiran-form', $kegiatan->slug)}}" class="btn btn-danger btn-lg scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                        <span>Isi Kehadiran Sivitas BPIP</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    @else
                    <div class="clearfix"><br></div>
                    <a href="{{ route('loginsso') }}" class="btn btn-danger btn-lg scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                        <span>Login Sivitas BPIP </span>
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    @endlogin
                    @else
                    @login
                    <div class="clearfix"><br></div>
                    <a href="{{ route('isi-kehadiran-form', $kegiatan->slug)}}" class="btn btn-danger btn-lg scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                        <span>Isi Kehadiran Sivitas BPIP</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    @else
                    <div class="clearfix"><br></div>
                    <a href="{{ route('loginsso') }}" class="btn btn-danger btn-lg scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                        <span>Login Sivitas BPIP </span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <div class="clearfix"></div>
                    <br>
                    <a href="{{ route('isi-kehadiran-form', $kegiatan->slug)}}" class="btn btn-primary btn-lg scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                        <span>Non Sivitas BPIP </span>
                        <i class="bi bi-arrow-right"></i>
                    </a>


                            @endlogin
                            @endif
                </div>
            </div>
        </div>


    </section>
</main><!-- End #main -->
@endsection
