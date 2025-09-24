@extends('backend.layouts.master')

@section('title')
Narasumber
@endsection

@section('content')

<section class="section">
  <div class="section-header">
    <h1>Narasumber</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>Daftar Hadir untuk Narasumber</h4>



        </div>




        <div class="card-body">
          <div class="alert alert-info" role="alert" style="font-size:15px">
            Fitur ini sedang dalam proses pengembangan.
          </div>

          <div class="buttons">
            <a href="/create" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Buat Daftar Hadir Kegiatan</a>
            <a href="/download-excel" class="btn btn-icon icon-left btn-success"><i class="fas fa-file-excel"></i> Download Excel</a>
            <a href="/print-pdf" class="btn btn-icon icon-left btn-danger"><i class="fas fa-file-pdf"></i> Print PDF</a>
          </div>
          <div class="table-responsive">
            <table class="table table-striped" id="table-kegiatan">
              <thead>
                <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th>Judul</th>
                  <th>Deskripsi</th>
                  <th class="text-center">Jam <Br>Awal</th>
                  <th class="text-center">Jam<Br> Akhir</th>
                  <th class="text-center">Peserta<Br>Absen</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
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