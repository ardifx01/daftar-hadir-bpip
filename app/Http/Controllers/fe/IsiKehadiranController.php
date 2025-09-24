<?php

namespace App\Http\Controllers\fe;

use Carbon\Carbon;
use App\Models\TrxMateri;
use App\Models\TrxPeserta;
use App\Models\MstKegiatan;
use Illuminate\Http\Request;
use App\Http\Classes\AuthSSO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\FIle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use stdClass;

class IsiKehadiranController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index($slug)
    {
        if (Auth::user()) {
            if (session()->has('slug')) {
                session()->forget('slug');
            }
        } else {
            $sessionslug = session()->put('slug', $slug);
        }

        $kegiatan = MstKegiatan::firstWhere('slug', $slug);
        if ((date('Y-m-d H:i:s') < $kegiatan->tgl_mulai) || (date('Y-m-d H:i:s') > $kegiatan->tgl_selesai)) {
            return view('frontend.pemberitahuan', compact('kegiatan', 'slug'));
        } else {

            return view('frontend.isi-kehadiran.welcome', compact('kegiatan', 'slug'));
        }
    }
    public function form($slug)
    {


        $token = AuthSso::token();
        $user_data = Cache::store('redis')->get($token . "#user");
        // dd($user_data);
        $kegiatan = MstKegiatan::firstWhere('slug', $slug);
        $file_materi = TrxMateri::Where('mst_kegiatan_id', $kegiatan->id)->get();
        return view('frontend.isi-kehadiran.form', compact('kegiatan', 'file_materi', 'user_data', 'slug'));
    }

    public function store(Request $request)
    {
        $code = '200';
        $status = 'OK';
        $message = '';


        $email = $request->email;
        $mst_kegiatan_id  = $request->mst_kegiatan_id;

        $validate = $request->validate([
            'jenis_peserta' => 'required',
            'status_peserta'   => 'required',
            'tipe_peserta'   => 'required',
            'email'   => [
                'required',
                Rule::unique('trx_peserta')->where(function ($query) use ($email, $mst_kegiatan_id) {
                    return $query->where('email', $email)
                        ->where('mst_kegiatan_id', $mst_kegiatan_id);
                }),
            ],
            'satuan_kerja_text'   => 'required',
            'instansi'   => 'required',
            'nama_lengkap_peserta'   => 'required',
            'no_telp'   => 'required',
            'mst_kegiatan_id'   => 'required',
            'ttd' => 'required',
        ], [
            'status_peserta.required' => 'Harap mengisi kolom Status Peserta',
            'tipe_peserta.required' => 'Harap mengisi kolom Tipe Peserta',
            'nama_lengkap_peserta.required' => 'Harap mengisi kolom Nama Lengkap',
            'satuan_kerja_text.required' => 'Harap mengisi kolom Satuan Kerja',
            'instansi.required' => 'Harap mengisi kolom Instansi',
            'email.required' => 'Harap mengisi kolom Email',
            'no_telp.required' => 'Harap mengisi kolom Nomor Telepon',
            'ttd.required' => 'Harap mengisi Tandatangan',
            'email.unique' => 'Peserta sudah mengisi daftar hadir ini',

        ]);

        if ($validate) {
            $user_data = new stdClass;
            if (Auth::user()) {
                $user_data = Auth::user();
            }
            $path = null;
            $filename_bukti_absen = null;
            $store_path = "public/".date('Y')."/".$request->kode_kegiatan;


            if ($request->ttd) {
                $image = base64_decode(str_replace('data:image/png;base64,', '', $request->ttd));
                $imageName = time() . '_' . $request->mst_kegiatan_id . '.' . 'png';

                storage::disk('local')->put($store_path."/".'tanda-tangan/' . $imageName, $image);
                $path = $store_path."/".'tanda-tangan/' . $imageName;

            }
            // if ($request->foto_bukti_absen) {
            //    // $image = base64_decode(str_replace('data:image/png;base64,', '', $request->ttd));
            //     $imageName = time() . '_' . $request->mst_kegiatan_id . '.' . 'png';
            //     storage::disk('local')->put($store_path."/".'foto-bukti-absen/' . $imageName, $image);
            //     $path_bukti_absen = $store_path."/".'foto-bukti-absen/' . $imageName;
            // }

            if ($request->file('foto_bukti_absen')) {
                $file = $request->file('foto_bukti_absen');

                $file_extension = $file->getClientOriginalExtension();
                $filename = "foto_bukti_absen_" . time() . '.' . $file_extension;

                // Upload file
                $path_bukti_absen = $request->file('foto_bukti_absen')->storeAs( 'storage/'.$store_path.'/foto_bukti_absen', $filename);
                $filename_bukti_absen = $path_bukti_absen;
            }

            if ($request->tipe_peserta == 'pns') {
                if ($user_data) {
                    $insert_kehadiran = TrxPeserta::create([
                        'jenis_peserta'      => $request->jenis_peserta,
                        'tipe_peserta'        => $request->tipe_peserta,
                        'status_peserta'        => $request->status_peserta,
                        'nip_nik'        => $request->nip_nik,
                        'nama_lengkap_peserta'            => $request->nama_lengkap_peserta,
                        'jabatan'              => $request->jabatan,
                        'satuan_kerja_text'              => $request->satuan_kerja_text,
                        'satuan_kerja_id'  => $request->satuan_kerja_id,
                        'instansi'  => $request->instansi,
                        'email'  => $request->email,
                        'no_hp' => $request->no_telp,
                        'tanda_tangan' => $path,
                        'waktu_presensi' => Carbon::now(),
                        'created_by'  => (count((array)$user_data) != 0) ? $user_data->usernameintra : null,
                        'updated_by'  => (count((array)$user_data) != 0)  ? $user_data->usernameintra : null,
                        'mst_kegiatan_id'  => $request->mst_kegiatan_id,
                        'pangkat'  => $request->pangkat,
                        'golongan'  => $request->golongan,
                        'foto_bukti_absen' => $filename_bukti_absen
                    ]);
                } else {
                    $insert_kehadiran = TrxPeserta::create([
                        'jenis_peserta'      => $request->jenis_peserta,
                        'tipe_peserta'        => $request->tipe_peserta,
                        'status_peserta'        => $request->status_peserta,
                        'nip_nik'        => $request->nip_nik,
                        'nama_lengkap_peserta'            => $request->nama_lengkap_peserta,
                        'jabatan'              => $request->jabatan,
                        'satuan_kerja_text'              => $request->satuan_kerja_text,
                        'instansi'  => $request->instansi,
                        'email'  => $request->email,
                        'no_hp' => $request->no_telp,
                        'tanda_tangan' => $path,
                        'waktu_presensi' => Carbon::now(),
                        'mst_kegiatan_id'  => $request->mst_kegiatan_id,
                        'pangkat'  => $request->pangkat,
                        'golongan'  => $request->golongan,
                        'foto_bukti_absen' => $filename_bukti_absen
                    ]);
                }
            } else {
                $insert_kehadiran = TrxPeserta::create([
                    'jenis_peserta'      => $request->jenis_peserta,
                    'tipe_peserta'        => $request->tipe_peserta,
                    'status_peserta'        => $request->status_peserta,
                    'nama_lengkap_peserta'            => $request->nama_lengkap_peserta,
                    'satuan_kerja_text'              => $request->satuan_kerja_text,
                    'instansi'  => $request->instansi,
                    'email'  => $request->email,
                    'no_hp' => $request->no_telp,
                    'tanda_tangan' => $path,
                    'waktu_presensi' => Carbon::now(),
                    'mst_kegiatan_id'  => $request->mst_kegiatan_id,
                    'foto_bukti_absen' => $filename_bukti_absen
                ]);
            }
            $call_back = array(
                'code' => $code,
                'status' => $status,
                'message' => $message,
                'data' => $insert_kehadiran
            );

            $json_encode = json_encode($call_back);

            return $json_encode;
            // return 'OK';
            // return redirect('/')->with('success', 'Kehadiran berhasil ditambahkan');
        }
    }


    public function success()
    {

        return view('frontend.isi-kehadiran.success');
    }
}
