@extends('backend.layouts.master')

@section('title')
Daftar Hadir Kegiatan-ku
@endsection

@section('content')

<section class="section">
  @if(session()->has('success'))
  <div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div>
  @endif
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>Daftar Peserta</h4>
          <div class="card-header-action">
          </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <b>Judul Kegiatan :</b> {{ $kegiatan->judul_kegiatan }}
                </div>
                <div class="col-md-12">
                    <b>Jenis Kegiatan :</b> {{ $kegiatan->jenis_kegiatan }}
                </div>
                <div class="col-md-12">
                    <b> Waktu :</b> {{ Carbon\Carbon::parse($kegiatan->tgl_mulai)->isoFormat('D MMM Y HH:mm') }} s/d {{ Carbon\Carbon::parse($kegiatan->tgl_selesai)->isoFormat('D MMM Y HH:mm') }}
                </div>
            </div>
            <br>
          <div class="table-responsive">
            <table class="table table-striped" id="table-kegiatan">
              <thead>
                <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th class="text-center">Jenis Peserta</th>
                  <th class="text-center">Nama/NIP/NIK</th>
                  <th class="text-center">Pangkat / Gol</th>
                  <th class="text-center">Jabatan / Satuan Kerja</th>
                  <th class="text-center">Instansi</th>
                  <th class="text-center">Email/No HP</th>
                  <th class="text-center">Waktu Absensi</th>
                  <th class="text-center">Foto Absen</th>
                  <th class="text-center">Tdd</th>
                </tr>
              </thead>
              <tbody>
                @if($data_peserta_kegiatan)
                    @php $no=1; @endphp
                    @foreach ($data_peserta_kegiatan as $item)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->jenis_peserta}}<br>{{ $item->tipe_peserta}}</td>
                        <td>{{ $item->nama_lengkap_peserta}}<br>{{ $item->nip_nik}}</td>
                        <td>{{ $item->pangkat}}<br>{{ $item->golongan}}</td>
                        <td>{{ $item->jabatan}}<br>{{ $item->satuan_kerja_text}}</td>
                        <td>{{ $item->instansi }}</td>
                        <td>{{ $item->email}}<br>{{ $item->no_hp}}</td>
                        <td align="center">{{ Carbon\Carbon::parse($item->waktu_presensi)->isoFormat('D MMM Y HH:mm') }}</td>
                        <td>
                            @if (Storage::disk('local')->exists($item->foto_bukti_absen))
                            <a href='{{ Storage::url($item->foto_bukti_absen )}}' target="_blank">Lihat</a>
                            @endif

                        </td>
                        <td>
                            @if (Storage::disk('local')->exists($item->tanda_tangan))
                            <a href='{{ Storage::disk('local')->url($item->tanda_tangan )}}' target="_blank">Lihat</a>
                            @endif
                        </td>
                      </tr>
                    @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')

<script>
  $(document).ready(function() {
    $('#table-kegiatan').DataTable({
      "ordering": false
    });


  });
</script>
@endpush
