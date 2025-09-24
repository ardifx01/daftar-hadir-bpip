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
          <h4>Daftar Hadir Kegiatan-Ku</h4>
          <div class="card-header-action">
          </div>
        </div>
        <div class="card-body">
          <div class="alert alert-info" role="alert" style="font-size:15px">
            Daftar hadir Kegiatan yang sudah pernah saya buat</b>
          </div>
          <div class="buttons">
            <a href="{{ route('kegiatan-create')}}" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i>Buat Daftar Hadir Kegiatan</a>
            {{-- <a href="{{env('URL_DAFTAR_HADIR_OLD')}}" class="btn btn-icon icon-left btn-success">Daftar Hadir Lama</a> --}}
            <!-- <a href="/download-excel" class="btn btn-icon icon-left btn-success"><i class="fas fa-file-excel"></i> Download Excel</a>
            <a href="/print-pdf" class="btn btn-icon icon-left btn-danger"><i class="fas fa-file-pdf"></i> Print PDF</a> -->
          </div>
          <div class="table-responsive">
            <table class="table table-striped" id="table-kegiatan">
              <thead>
                <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th class="text-center">Judul</th>

                  <th class="text-center">Deskripsi</th>
                  <th class="text-center"> Lokasi</th>
                  <th class="text-center">Satker Penyelenggara</th>
                  <th class="text-center">Tanggal Kegiatan</th>
                  <th class="text-center">Jam Kegiatan</th>
                  <th class="text-center">Url Kegiatan</th>
                  <th class="text-center">Peserta<Br>Absen</th>
                  <th class="text-center">File Undangan</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @php $no=1; @endphp
                @foreach ($data_kegiatan as $item_kegiatan)
                <tr>
                  <td style="font-size: 10px" class="text-center">{{ $no++ }}</td>
                  <td style="font-size: 10px" class="text-center">{{ $item_kegiatan->judul_kegiatan}}</td>
                  <td style="font-size: 10px" class="text-center">{{ $item_kegiatan->deskripsi_kegiatan}}</td>
                  <td style="font-size: 10px" class="text-center">{{ $item_kegiatan->lokasi_kegiatan}}</td>
                  <td style="font-size: 10px" class="text-center">{{ $item_kegiatan->satuan_kerja_text}}</td>
                  <td style="font-size: 10px" class="text-center">
                    @if(Carbon\Carbon::parse($item_kegiatan->tgl_mulai)->isoFormat('D MMM Y') != Carbon\Carbon::parse($item_kegiatan->tgl_selesai)->isoFormat('D MMM Y'))
                    {{ Carbon\Carbon::parse($item_kegiatan->tgl_mulai)->isoFormat('D MMM Y')}} - {{ Carbon\Carbon::parse($item_kegiatan->tgl_selesai)->isoFormat('D MMM Y')}}
                    @else
                    {{ Carbon\Carbon::parse($item_kegiatan->tgl_mulai)->isoFormat('D MMM Y')}}
                    @endif
                  </td>
                  <td style="font-size: 10px" class="text-center">

                    {{ Carbon\Carbon::parse($item_kegiatan->tgl_mulai)->isoFormat('HH:mm')}} - {{ Carbon\Carbon::parse($item_kegiatan->tgl_selesai)->isoFormat('HH:mm')}}

                  </td>
                  <td style="font-size: 10px" class="text-center">
                    <input type="hidden" value="{{ route('isi-kehadiran', $item_kegiatan->slug )}}" placeholder="" id="link-copy-{{ $item_kegiatan->id }}">
                    <a href="#" class="btn-click-copy" data-id={{ $item_kegiatan->id }}>Klik<Br>Copy<br>Url</a>
                  </td>
                  <td style="font-size: 10px" class="text-center">
                    @if ($item_kegiatan->trx_peserta_count>0)
                    <a href='{{  route('kegiatan-list-peserta', $item_kegiatan->id) }}' target="_blank">{{ $item_kegiatan->trx_peserta_count}} (lihat)</a>
                    @else
                    0
                    @endif

                  </td>
                  <td> @if ($item_kegiatan->file_undangan!==null)
                    <a href="{{ Storage::url($item_kegiatan->file_undangan) }}" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-download"></i></a>
                    @else
                    <p>Tidak ada file</p>
                    @endif
                  </td>
                  <td class="text-center">
                    <a href="{{ route('kegiatan-cetak', $item_kegiatan->id)}}" class="btn btn-xs btn-success" target="_blank">Cetak</a>
                    <a href="{{ route('kegiatan-edit', $item_kegiatan->id)}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-xs btn-danger btn-delete-kegiatan" data-id={{ $item_kegiatan->id }}><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                @endforeach
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
    $('.btn-click-copy').on('click', function(e) {
      event.preventDefault();
      let id = $(this).data("id");
      var url = $("#link-copy-" + id).val();
      //alert(copyText);

      var temp = $("<input>");
      $("body").append(temp);
      temp.val(url).select();
      document.execCommand("copy");
      temp.remove();

      Swal.fire(
        'Berhasil!',
        'Menyalin Link Form Daftar Hadir',
        'success'
      )
    });
    $('body').on('click', '.btn-delete-kegiatan', function(event) {
      event.preventDefault();

      let id = $(this).attr("data-id");

      Swal.fire({
        title: 'Apakah kamu yakin?',
        text: "Ingin Menghapus Data",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('kegiatan-destroy')}}",
            type: "POST",
            data: {
              _token: "{{ csrf_token() }}",
              id: id,
            },
            dataType: "json",
            success: function(result) {
              // console.log(result);
              if (result.status == 'OK') {
                Swal.fire({
                  title: 'Berhasil',
                  text: "Data Kegiatan Berhasil Dihapus",
                  icon: 'success',
                }).then((hasil) => {
                  window.location.href = "{{ route('kegiatan') }}";
                });
              } else {
                Swal.fire(
                  'Gagal!',
                  result.message,
                  'error'
                )
              }
            }

          });

        }
      })

    });

  });
</script>
@endpush
