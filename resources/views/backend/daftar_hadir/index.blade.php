@extends('backend.layouts.master')

@section('title')
Daftar Hadir-ku
@endsection

@section('content')

<section class="section">
  <div class="section-header">
    <h1>Daftar Hadir-Ku</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>List Daftar Hadir Rapat yang telah saya ikuti</h4>
          <div class="card-header-action">
          </div>
        </div>

        <div class="card-body">
          {{-- <div class="alert alert-info" role="alert" style="font-size:15px">
            List Daftar hadir kegiatan pada versi sebelumnya dapat diakses pada tombol <b>List Kegiatan Daftar Hadir Lama</b>
          </div> --}}
          {{-- <div class="buttons">
            <!-- <a href="/download-excel" class="btn btn-icon icon-left btn-success"><i class="fas fa-file-excel"></i> Download Excel</a> -->
            <a href="{{env('URL_DAFTAR_HADIR_OLD')}}/akses_sivitas/kegiatan/presensi_kegiatan/" class="btn btn-icon icon-left btn-primary"> List Kegiatan Daftar Hadir Lama</a>
          </div> --}}
          <div class="table-responsive">
            <table class="table table-striped" id="table-kegiatan">
              <thead>
                <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th class="text-center">Judul</th>
                  <th class="text-center">Penyelenggara</th>
                  <th class="text-center">Deskripsi</th>
                  <th class="text-center">Jenis Kegiatan</th>
                  <th class="text-center">Jadwal Kegiatan</th>
                  <th class="text-center">Waktu Presensi</th>
                  @if (env('SHOW_TTD')== '1')
                  <th class="text-center">Tanda tangan</th>
                  @endif
                </tr>
              </thead>

              <tbody>
                @if($data_list_daftar_hadir)
                @php $no=1; @endphp
                @foreach ($data_list_daftar_hadir as $item_list_daftar_hadir)
                <tr>
                  <td style="font-size: 10px" class="text-center">{{ $no++ }}</td>
                  <td style="font-size: 10px" class="text-center">{{ $item_list_daftar_hadir->mst_kegiatan->judul_kegiatan}}</td>
                  <td style="font-size: 10px" class="text-center">{{ $item_list_daftar_hadir->mst_kegiatan->satuan_kerja_text}}</td>
                  <td style="font-size: 10px" class="text-center">{{ $item_list_daftar_hadir->mst_kegiatan->deskripsi_kegiatan}}</td>
                  <td style="font-size: 10px" class="text-center">{{ $item_list_daftar_hadir->mst_kegiatan->jenis_kegiatan}}</td>
                  <td style="font-size: 10px" class="text-center">
                    @if(Carbon\Carbon::parse($item_list_daftar_hadir->mst_kegiatan->tgl_mulai)->isoFormat('D MMM Y') != Carbon\Carbon::parse($item_list_daftar_hadir->mst_kegiatan->tgl_selesai)->isoFormat('D MMM Y'))
                    {{ Carbon\Carbon::parse($item_list_daftar_hadir->mst_kegiatan->tgl_mulai)->isoFormat('D MMM Y')}} - {{ Carbon\Carbon::parse($item_list_daftar_hadir->mst_kegiatan->tgl_selesai)->isoFormat('D MMM Y')}}
                    @else
                    {{ Carbon\Carbon::parse($item_list_daftar_hadir->mst_kegiatan->tgl_mulai)->isoFormat('D MMM Y')}}
                    @endif
                    <br>
                    {{ Carbon\Carbon::parse($item_list_daftar_hadir->mst_kegiatan->tgl_mulai)->isoFormat('HH mm')}} - {{ Carbon\Carbon::parse($item_list_daftar_hadir->mst_kegiatan->tgl_selesai)->isoFormat('HH mm')}}
                  </td>
                  <td style="font-size: 10px" class="text-center"> {{ Carbon\Carbon::parse($item_list_daftar_hadir->waktu_presensi)->isoFormat('dddd, D MMM Y, HH:mm')}} WIB</td>
                  @if (env('SHOW_TTD')== '1')
                  <td class="text-center">
                    <a target="_blank" href='{{ Storage::disk('minio')->url($item_list_daftar_hadir->tanda_tangan) }}'>Lihat Tanda tangan</a></td>
                  @endif
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
