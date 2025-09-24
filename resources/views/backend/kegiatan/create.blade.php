@extends('backend.layouts.master')

@section('title')
Buat Kegiatan-ku
@endsection

@section('content')

<section class="section">
    {{-- <div class="section-header">
        <h1>Buat Daftar Hadir </h1>
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h4>Daftar Hadir Kegiatan-Ku</h4>
                  <div class="card-header-action">
                  </div>
                </div>
                <div class="card-body">
                    <form role="form" action="{{ route('kegiatan-store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="form-body">
                            <div class="form-group">
                                <label>Judul Kegiatan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-pen"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control spinner" name="judul_kegiatan" placeholder="">
                                    @error('judul_kegiatan')
                                    <div class="invalid-feedback"> Judul Kegiatan Invalid</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Lokasi Kegiatan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-map-marker"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control spinner" name="lokasi_kegiatan" placeholder="">
                                    @error('lokasi_kegiatan')
                                    <div class="invalid-feedback"> Lokasi Kegiatan Invalid</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kegiatan
                                    <span class=" required"> * </span>
                                </label>
                                <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-control spinner ">
                                    <option value="">Pilih Jenis Kegiatan..</option>
                                    <option value="internal">Kegiatan Internal</option>
                                    <option value="eksternal">Kegiatan Eksternal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Satuan Kerja Penyelenggara</label>
                                {!! Form::select('parameter_satker', $arr_satker, null, array('class' => 'form-control', 'id'=>'satker')) !!}
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Mulai</label>
                                        <input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai">
                                        <script>
                                            $('#tgl_mulai').datetimepicker({
                                                showOtherMonths: true,
                                                calendarWeeks: true,
                                                format: 'yyyy-mm-dd HH:MM',
                                                uiLibrary: 'bootstrap4',
                                                size: 'default',
                                                modal: false,
                                                footer: true
                                            })
                                        </script>
                                    </div>
                                    @error('tgl_mulai')
                                    <div class="invalid-feedback"> Tanggal Mulai Invalid</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Selesai</label>
                                        <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai">
                                        <script>
                                            $('#tgl_selesai').datetimepicker({
                                                showOtherMonths: true,
                                                calendarWeeks: true,
                                                format: 'yyyy-mm-dd HH:MM',
                                                uiLibrary: 'bootstrap4',
                                                size: 'default',
                                                modal: false,
                                                footer: true
                                            })
                                        </script>
                                    </div>
                                    @error('tgl_selesai')
                                    <div class="invalid-feedback"> Tanggal Selesai Invalid</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Moderator</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control spinner" name="moderator" placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>File Undangan</label>

                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="fas fa-file"></i>
                                    </div>
                                    <input type="file" class="form-control" name="file_undangan" placeholder="">
                                    @error('file_undangan')
                                    <div class="invalid-feedback"> File Undangan Invalid</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Kegiatan</label>
                                <div class="input-group">

                                    <textarea class="form-control" name="deskripsi" style="height: 150px;"></textarea>
                                </div>

                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-save"></i> Submit</button>
                                <a href="/kegiatan" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                    </form>
                </div>
              </div>

        </div>
    </div>
</section>
@endsection

@push('js-script')



</head>

<body>


    <script>
        $(document).ready(function() {


            $('#satker').select2();


        });
    </script>
    @endpush
