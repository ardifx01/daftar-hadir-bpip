@extends('backend.layouts.master')
@push('css-script')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('public/backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{ asset('public/backend/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/backend/assets/modules/select2/dist/css/select2.css')}}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush
@section('title')
Edit Kegiatan-ku
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Edit Daftar Hadir </h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="{{ route('kegiatan-store', ['id' => $data_kegiatan->id]) }}">
                @method('PUT')
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
                            <input type="text" class="form-control spinner" name="judul_kegiatan" value="{{ $data_kegiatan->judul_kegiatan }}" placeholder="">
                            <input type="hidden" class="form-control" name="role" value="{{ $role }}" placeholder="">
                            @error('judul_kegiatan')
                            <div class="invalid-feedback"> Judul Kegiatan Invalid</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label>Lokasi Kegiatan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control spinner" name="lokasi_kegiatan" value="{{ $data_kegiatan->lokasi_kegiatan }}" placeholder="">
                                @error('lokasi_kegiatan')
                                <div class="invalid-feedback"> Lokasi Kegiatan Invalid</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kegiatan
                                <span class="required"> * </span>
                            </label>
                            <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-control spinner ">
                                <option value="">Pilih Jenis Kegiatan..</option>
                                <option value="internal" {{ ($data_kegiatan->jenis_kegiatan == "internal") ? "selected" : "" }}>Kegiatan Internal</option>
                                <option value="eksternal" {{ ($data_kegiatan->jenis_kegiatan == "eksternal") ? "selected" : "" }}>Kegiatan Eksternal</option>
                            </select>
                        </div>
                        <div class="form-group" id="satker">
                            <label>Satuan Kerja Penyelenggara</label>
                            {!! Form::select('parameter_satker', $arr_satker, $data_kegiatan->satuan_kerja_id . '#' . $data_kegiatan->satuan_kerja_text, array('class' => 'form-control','id'=>'satker')) !!}
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai" value="{{ $data_kegiatan->tgl_mulai}}">
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
                                    <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai" value="{{ $data_kegiatan->tgl_selesai}}">
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
                                <input type="text" class="form-control spinner" value="{{ $data_kegiatan->moderator}}" name="moderator" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>File Undangan</label>
                            <div class="input-group">
                                <input type="file" class="form-control" value="{{ $data_kegiatan->file_undangan }}" name="file_undangan" placeholder="">
                                @error('file_undangan')
                                <div class="invalid-feedback"> File Undangan Invalid</div>
                                @enderror
                            </div>
                            @if ($data_kegiatan->file_undangan!==null)
                            <a href="{{ Storage::disk('minio')->url($data_kegiatan->file_undangan) }}">Download File Sebelumnya</a>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Kegiatan </label>
                            <textarea class="form-control" name="deskripsi" rows="5">{{ $data_kegiatan->deskripsi_kegiatan }}</textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue"><i class="fa fa-save"></i> Submit</button>
                        @if ($role == 'admin')
                        <a href="{{ url()->previous() }}" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                        @else
                        <a href="/kegiatan" class="btn btn-md btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                        @endif

                    </div>
            </form>
        </div>
    </div>

</section>
@endsection

@push('js-script')
<script src="{{ asset('public/backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ asset('public/backend/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




<script>
    $(document).ready(function() {
        $('#satker').select2();
    });
</script>
@endpush
