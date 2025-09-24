

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="telephone=no" name="format-detection">
    <title>Laporan Daftar Hadir</title>

</head>
<br>
<br>
<table>
    <tr>
	<td align="center">
    <img alt="image" src="/backend/assets/img/logo-bpip.png" class="rounded-circle mr-1"width="100" height="100">
</td>

</tr>
    <tr>
	<td align="center" class="font font-size-14">
	    <br>DAFTAR HADIR
        <br>Badan Pembinaan Ideologi Pancasila
</td>
</tr>


    @if($data_kegiatan)
    <div align="justify" style="font-size:11px">
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" style="font-size:9px;">Agenda &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$data_kegiatan->judul_kegiatan}}</td>
            </tr>
            <tr>
                <td align="left" style="font-size:9px;">Hari, Tanggal &nbsp;&nbsp;&nbsp; : @if(Carbon\Carbon::parse($data_kegiatan->tgl_mulai)->isoFormat('D MMM Y') != Carbon\Carbon::parse($data_kegiatan->tgl_selesai)->isoFormat('D MMM Y'))
                    {{ Carbon\Carbon::parse($data_kegiatan->tgl_mulai)->isoFormat('D MMM Y')}} - {{ Carbon\Carbon::parse($data_kegiatan->tgl_selesai)->isoFormat('D MMM Y')}}
                    @else
                    {{ Carbon\Carbon::parse($data_kegiatan->tgl_mulai)->isoFormat('D MMM Y')}}
                    @endif

                </td>
            </tr>
            <tr>
                <td align="left" style="font-size:9px;">Waktu Kegiatan : {{ Carbon\Carbon::parse($data_kegiatan->tgl_mulai)->isoFormat('HH:mm')}} - {{ Carbon\Carbon::parse($data_kegiatan->tgl_selesai)->isoFormat('HH:mm')}} WIB
                </td>
            </tr>
            <tr>
                <td align="left" style="font-size:9px;">Tempat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$data_kegiatan->lokasi_kegiatan}}</td>
            </tr>
            <tr>
                <td align="left" style="font-size:9px;">Moderator &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$data_kegiatan->moderator}}</td>
            </tr>
            <tr>
                <td align="left" style="font-size:9px;">Total Peserta &nbsp;&nbsp;&nbsp;&nbsp;: {{$data_peserta_kegiatan->count()}}</td>
            </tr>
        </table>
    </div>
    @endif

    <div align="justify" style="font-size:11px">
        <table border="1" cellpadding="3">

            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;text-align: center;font-size: 8px;">
                        No.
                    </th>
                    <th class="text-center" style="width: 10%;text-align: center;font-size: 8px;background-color:#f7cac9">NAMA LENGKAP</th>
                    <th class="text-center" style="width: 10%;text-align: center;font-size: 8px;background-color:#f7cac9">NIP</th>
                    <th class="text-center" style="width: 10%;text-align: center;font-size: 8px;background-color:#f7cac9">INSTANSI</th>
                    <th class="text-center" style="width: 15%;text-align: center;font-size: 8px;background-color:#f7cac9">SATUAN KERJA</th>
                    <th class="text-center" style="width: 7%;text-align: center;font-size: 8px;background-color:#f7cac9">JABATAN</th>
                    <th class="text-center" style="width: 10%;text-align: center;font-size: 8px;background-color:#f7cac9">NO. TELP</th>
                    <th class="text-center" style="width: 10%;text-align: center;font-size: 8px;background-color:#f7cac9">EMAIL</th>
                    <th class="text-center" style="width: 10%;text-align: center;font-size: 8px;background-color:#f7cac9">WAKTU PRESENSI</th>
                    
                    <th class="text-center" style="width: 16%;text-align: center;font-size: 8px;">TANDATANGAN</th>
                    
                </tr>
            </thead>

            <tbody>
                @if($data_peserta_kegiatan)
                @php $no=1; @endphp
                @foreach ($data_peserta_kegiatan as $value)

                <tr>
                    <td style="width: 5%;text-align: center;font-size: 8px;" class="text-center">{{ $no++ }}</td>
                    <td style="width: 10%;text-align: left;font-size: 8px;" class="text-center">{{ $value->nama_lengkap_peserta}}</td>
                    <td style="width: 1-%;text-align: left;font-size: 8px;" class="text-center">{{ $value->nip_nik}}</td>
                    <td style="width: 10%;text-align: left;font-size: 8px;" class="text-center">{{ $value->instansi}}</td>
                    <td style="width: 15%;text-align: left;font-size: 8px;" class="text-center">{{ $value->satuan_kerja_text}}</td>
                    <td style="width: 7%;text-align: left;font-size: 8px;" class="text-center">{{ $value->jabatan}}</td>
                    <td style="width: 10%;text-align: left;font-size: 8px;" class="text-center">{{ $value->no_hp}}</td>
                    <td style="width: 10%;text-align: left;font-size: 8px;" class="text-center">{{ $value->email}}</td>
                    <td style="width: 10%;text-align: left;font-size: 8px;" class="text-center"> {{ Carbon\Carbon::parse($value->waktu_presensi)->isoFormat('D MMM Y, HH:mm')}} WIB</td>
                    
                    @if($value->tanda_tangan!==null)
                    <td style="width: 16%;text-align: center;font-size: 8px; padding: 15px;" class="text-center"><img src="{{Storage::url($value->tanda_tangan)}}" alt="" width="50px" height="50px"></td>
                    @else
                    <td style="width: 16%;text-align: left;font-size: 8px;" class="text-center">tidak tanda-tangan</td>
                    @endif
                    
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

</body>

</html>
