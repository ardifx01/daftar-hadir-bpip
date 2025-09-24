@extends('frontend.layouts.master')

@section('content')
<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section class="breadcrumbs">
    <div class="container">

      <ol>
        <li><a href="index.html">Beranda</a></li>
        <li>Isi Daftar Hadir</li>
      </ol>

    </div>
  </section><!-- End Breadcrumbs -->
  <link href="{{ asset('frontend/assets/css/jquery.signature.css') }}" rel="stylesheet">



  <style>
    .kbw-signature {
      width: 100%;
      height: 200px;
    }

    #sig canvas {
      width: 100% !important;
      height: auto;
    }

    .info-box {
      color: #444444;
      background: #fafbff;
      padding: 30px;
    }

    #signature {
      width: 100%;
      height: auto;
      top: 0px;
      position: relative;
      border: thin solid #d3d3d3;

    }
  </style>
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
      <header class="section-header">
        <h2>Daftar Hadir</h2>
        <p>Lembar Daftar Hadir</p>
      </header>


      <div class="row gy-4">
        <div class="col-lg-4">
          <div class="row gy-4">
            <div class="col-md-12">
              <div class="info-box">
                <i class="bi bi-pencil"></i>
                <h3>Judul</h3>
                <p>{{ $kegiatan->judul_kegiatan }}</p>
              </div>
            </div>
            @if (isset($kegiatan->file_undangan))
            <div class="col-md-12">
              <div class="info-box">
                <i class="bi bi-envelope-open"></i>
                <h3>Undangan</h3>
                <p><a href="{{ Storage::disk('minio')->url($kegiatan->file_undangan) }}">File Undangan</a></p>
              </div>
            </div>
            @endif
            <div class="col-md-12">
              <div class="info-box">
                <i class="bi bi-geo-alt"></i>
                <h3>Tempat</h3>
                <p>{{ $kegiatan->lokasi_kegiatan }}</p>
              </div>
            </div>
            <div class="col-md-12">
              <div class="info-box">
                <i class="bi bi-clock"></i>
                <h3>Waktu</h3>
                @if (Carbon\Carbon::parse($kegiatan->tgl_mulai)->toDateString() == Carbon\Carbon::parse($kegiatan->tgl_selesai)->toDateString())
                <p> {{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->translatedformat('d F Y') }}<br>{{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->format('H:i').' - '.Carbon\Carbon::parse($kegiatan->tgl_selesai)->format('H:i')}} WIB</p>
                @else
                <p> {{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->translatedformat('d F Y H:i')}} WIB - <br>{{ Carbon\Carbon::parse($kegiatan->tgl_selesai)->translatedformat('d F Y H:i')}} WIB</p>
                @endif
              </div>
            </div>
            @if ($file_materi->isNotEmpty())
            <div class="col-md-12">
              <div class="info-box">
                <i class="bi bi-download"></i>
                <h3>Materi</h3>
                <p>
                  @foreach ($file_materi as $file)
                  <a href='{{ Storage::disk('minio')->url($file->link_file) }}'>{{ $file->nama_file }}</a><br>
                  @endforeach
                </p>
              </div>
            </div>
            @endif
          </div>
        </div>
        <div class="col-lg-8">
          <form method="POST" id="frmdaftar" action="" enctype="multipart/form-data" class="php-email-form">

            @csrf
            {{ Form::hidden('mst_kegiatan_id', $kegiatan->id) }}
            {{ Form::hidden('kode_kegiatan', $kegiatan->kode_kegiatan) }}
            <div class="row gy-4">
              @if($user_data==null)
              {{ Form::hidden('jenis_peserta', 'Eksternal') }}
              @if($kegiatan->jenis_kegiatan=='eksternal')
              <div class="row gy-4">
                <div class="col-md-12">
                  <div class="control-label">Tipe Peserta
                    <span style="color:red">*</span>
                  </div>
                  <div class="custom-switches-stacked mt-2">
                    <label class="custom-switch">
                      <input type="radio" id="tipe_peserta" name="tipe_peserta" value="pns" class="custom-switch-input" checked>
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">PNS</span>
                    </label>
                    <label class="custom-switch">
                      <input type="radio" id="tipe_peserta" name="tipe_peserta" value="non-pns" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">Non-PNS</span>
                    </label>
                  </div>
                </div>
                <div class="col-md-12" id="status_peserta">
                  <div class="control-label">Status Peserta
                    <span style="color:red">*</span>
                  </div>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-arrow-down"></i>
                    </div>
                    <select class="form-control" name="status_peserta" id="status_peserta">
                      <option value='0'>Pilih Status Peserta</option>
                      <option value='pekerja'>Pekerja</option>
                      <option value='mahasiswa'>Mahasiswa</option>
                      <option value='pelajar'>Pelajar</option>
                      <option value='umum'>Umum</option>
                    </select>
                  </div>
                </div>

                @endif
                <div class="col-md-8" id="nip">
                  <label for="nip" class="form-label">NIP</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-users-cog"></i>
                    </div>
                    <input type="text" class="form-control" id="nip" value="" name="nip_nik" placeholder="Masukkan NIP">
                  </div>
                </div>
                <div class="col-md-4 ">
                  <label for="email" class="form-label">Email Aktif</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" id="email" class="form-control" value="" name="email" placeholder="Masukkan Alamat Email">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="nama_lengkap_peserta" class="form-label">Nama Lengkap</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-file-signature"></i>
                    </div>
                    <input type="text" name="nama_lengkap_peserta" value="" id="nama_lengkap_peserta" class="form-control" placeholder="Masukkan Nama">
                  </div>
                </div>
                <div class="col-md-12" id="jabatan">
                  <label for="jabatan" class="form-label">Jabatan</label>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-user-tie"></i>
                    </div>
                    <input type="text" class="form-control" value="" id="jabatan" name="jabatan" placeholder="Masukkan Jabatan (isi bila ada)">
                  </div>
                </div>
                <div class="col-md-6" id="pangkat" hidden>
                  <label for="pangkat" class="form-label">Pangkat</label>

                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-hourglass-start"></i>
                    </div>
                    <input type="text" class="form-control" value="" id="pangkat" name="pangkat" placeholder="Masukkan Pangkat (isi bila ada)">
                  </div>
                </div>
                <div class="col-md-6" id="golongan" hidden>
                  <label for="golongan" class="form-label">Golongan</label>

                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-glasses"></i>
                    </div>
                    <input type="text" class="form-control" value="" id="golongan" name="golongan" placeholder="Masukkan Golongan (isi bila ada)">
                  </div>
                </div>
                <div class="col-md-12" id="satuan_kerja_text">
                  <label for="satuan_kerja_text" class="form-label">Satuan Kerja</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="far fa-object-group"></i>
                    </div>
                    <input type="text" class="form-control" value="" id="satuan_kerja_text" name="satuan_kerja_text" placeholder="Masukkan Satuan Kerja">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="instansi" class="form-label">Instansi</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-sitemap"></i>
                    </div>
                    <input type="text" class="form-control" value="" id="instansi" name="instansi" placeholder="Masukkan Instansi">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="no_telp">Nomor Handphone</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </div>
                    <input type="text" id="no_telp" name="no_telp" value="" class="form-control phone-number" placeholder="Masukkan nomor telepon">
                  </div>
                </div>
                @else
                {{ Form::hidden('jenis_peserta', 'Internal') }}
                {{ Form::hidden('satuan_kerja_id', $user_data->satuan_kerja_id) }}
                {{ Form::hidden('tipe_peserta', 'pns') }}
                {{ Form::hidden('status_peserta', 'pekerja') }}
                <div class="col-md-8" id="nip">
                  <label for="nip" class="form-label">NIP</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-users-cog"></i>
                    </div>
                    <input type="text" class="form-control" id="nip_nik" value="{{$user_data->nip}}" name="nip_nik" placeholder="Masukkan NIP">
                  </div>
                </div>
                <div class="col-md-4 ">
                  <label for="email" class="form-label">Email Aktif</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" id="email" class="form-control" value="{{$user_data->email}}" name="email" placeholder="Masukkan Alamat Email">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="nama_lengkap_peserta" class="form-label">Nama Lengkap</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-file-signature"></i>
                    </div>
                    <input type="text" name="nama_lengkap_peserta" value="{{$user_data->name}}" id="nama_lengkap_peserta" class="form-control" placeholder="Masukkan Nama">
                  </div>
                </div>
                <div class="col-md-12" id="jabatan">
                  <label for="jabatan" class="form-label">Jabatan</label>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-user-tie"></i>
                    </div>
                    <input type="text" class="form-control" value="{{$user_data->jabatan}}" id="jabatan" name="jabatan" placeholder="Masukkan Jabatan (isi bila ada)">
                  </div>
                </div>
                <div class="col-md-6" id="pangkat">
                  <label for="pangkat" class="form-label">Pangkat</label>

                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-hourglass-start"></i>
                    </div>
                    <input type="text" class="form-control" value="{{$user_data->pangkat}}" id="pangkat" name="pangkat" placeholder="Masukkan Pangkat (isi bila ada)">
                  </div>
                </div>
                <div class="col-md-6" id="golongan">
                  <label for="golongan" class="form-label">Golongan</label>

                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-glasses"></i>
                    </div>
                    <input type="text" class="form-control" value="{{$user_data->golongan}}" id="golongan" name="golongan" placeholder="Masukkan Golongan (isi bila ada)">
                  </div>
                </div>
                <div class="col-md-12" id="satuan_kerja_text">
                  <label for="satuan_kerja_text" class="form-label">Satuan Kerja</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="far fa-object-group"></i>
                    </div>
                    <input type="text" class="form-control" value="{{$user_data->satuan_kerja}}" id="satuan_kerja_text" name="satuan_kerja_text" placeholder="Masukkan Satuan Kerja">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="instansi" class="form-label">Instansi</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-sitemap"></i>
                    </div>
                    <input type="text" class="form-control" value="{{$user_data->instansi}}" id="instansi" name="instansi" placeholder="Masukkan Instansi">
                  </div>
                </div>
                <div class="col-md-12">
                  <label for="no_telp">Nomor Handphone</label>
                  <span style="color:red">*</span>
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </div>
                    <input type="text" id="no_telp" name="no_telp" value="{{$user_data->telepon}}" class="form-control phone-number" placeholder="Masukkan nomor telepon">
                  </div>
                </div>
                @endif
                <div class="col-md-12">
                    <label for="no_telp">Foto Bukti Absen</label>
                    {{-- <span style="color:red">*</span> --}}
                    <div class="input-group">
                      <div class="input-group-text">
                        <i class="fas fa-camera"></i>
                      </div>
                      <input type="file" id="foto_bukti_absen" name="foto_bukti_absen" class="form-control">
                    </div>
                  </div>
                <div class="col-md-12">
                  <label for="tanda_tangan">Tandatangan</label>
                  <span style="color:red">*</span>
                  <br />
                  <div id="sig"></div>
                  <br><br>
                  <button id="clear" class="btn btn-danger">Clear Signature</button>
                  <textarea id="signature" name="ttd" style="display: none"></textarea>
                </div>
                <div class="col-md-12">
                  {{-- <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Kehadiran berhasil ditambahkan</div> --}}
                  <button type="submit" class="btn btn-success" id="btn-simpan-daftar-hadir-new">Submit</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="{{ asset('backend/assets/modules/sweetalert/sweetalert.min.js')}}" type="text/javascript">

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('frontend/assets/js/jquery.signature.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.signature.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.ui.touch-punch.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('input[type=radio][name=tipe_peserta]').change(function() {
      if (this.value == 'non-pns') {
        $("#nip").hide();
        $("#pangkat").hide();
        $("#golongan").hide();
        $("#jabatan").hide();
        $("#satuan_kerja_text").show();
      } else if (this.value == 'pns') {
        $("#nip").show();
        $("#pangkat").show();
        $("#golongan").show();
        $("#jabatan").show();
        $("#satuan_kerja_text").show();
        $("#status_peserta").hide();
      }
    });
    var sig = $('#sig').signature({
      syncField: '#signature',
      syncFormat: 'PNG'
    });
    $('#clear').click(function(e) {
      e.preventDefault();
      sig.signature('clear');
      $("#signature").val('');
    });

    $('#frmdaftar').on('submit', function (params) {
        event.preventDefault();
      Swal.fire({
        title: 'Apakah Yakin?',
        text: "Data sudah sesuai?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, saya yakin!'
      }).then((result) => {
        if (result.value) {

            $.ajax({
                url: "{{ route('isi-kehadiran-store')}}",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {

                },
            success: function(data)
                {
                   console.log(data);
                   Swal.fire(
                        "Berhasil!",
                        "Anda Telah Mengisi Presensi Kegiatan!",
                        "success",
                    )
                    location.href = "{{ route('success')}}"
                },
            error: function(xhr, ajaxOptions, thrownError) {
                // error: function(data) {

                var errors = '';
                for (keys in xhr.responseJSON.errors) {
                    errors += xhr.responseJSON.errors[keys] + '<br>';
                }

                Swal.fire({
                    title: "Gagal !",
                    html: errors + '<br>',
                    icon: "error",
                })
            }
        });
        }
      });


        /*

        */
    });

    $('#btn-simpan-daftar-hadir').click(function(e) {
      event.preventDefault();
      Swal.fire({
        title: 'Apakah Yakin?',
        text: "Data sudah sesuai?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, saya yakin!'
      }).then((result) => {
        if (result.value) {

          let formData = new FormData(this);

          $.ajax({
            url: "{{ route('isi-kehadiran-store')}}",
            type: "POST",
            data: $("#frmdaftar").serialize(),
            dataType: "json",

            success: function(data) {
              Swal.fire(
                "Berhasil!",
                "Anda Telah Mengisi Presensi Kegiatan!",
                "success",
              )
              location.href = "{{ route('success')}}"
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // error: function(data) {

              var errors = '';
              for (keys in xhr.responseJSON.errors) {
                errors += xhr.responseJSON.errors[keys] + '<br>';
              }

              Swal.fire({
                title: "Gagal !",
                html: errors + '<br>',
                icon: "error",
              })
            }
          });
        }
      })
    });

  });
</script>
@endpush
