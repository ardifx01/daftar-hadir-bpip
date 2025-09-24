<?php

namespace App\Http\Controllers\be;

use App\Http\Classes\AuthSSO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MstKegiatan;
use App\Models\TrxPeserta;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use PDF;


class KegiatanController extends Controller
{
    //
    public function __construct()
    {
        $token = AuthSSO::token();
        $user_data = Cache::store('redis')->get($token . "#user");
        if(!$user_data){
            redirect(route('beranda'));
        }
    }

    public function index()
    {
        $token = AuthSSO::token();
        $user_data = Cache::store('redis')->get($token . "#user");
        if(!$user_data){
            redirect(route('beranda'));
        }
        $data_kegiatan = MstKegiatan::withCount('trx_peserta')->where('deleted_at', null)->orderBy('created_at', 'desc')->where('created_by', '=', $user_data->usernameintra)->get();
        return view('backend.kegiatan.index', compact('data_kegiatan'));
    }

    public function create()
    {

        $data_satker = AuthSSO::getSatuanKerja();
       // dd($data_satker);

        $arr_satker = array();
        foreach ($data_satker->data as $item_satker) {

            $arr_satker[$item_satker->id . "#" . $item_satker->name] = $item_satker->name;
        }



        return view('backend.kegiatan.create', compact('arr_satker'));
    }
    public function store(Request $request)
    {

        $validate = $request->validate([
            'judul_kegiatan' => 'required',
            'parameter_satker'   => 'required',
            'tgl_mulai'   => 'required',
            'tgl_selesai'   => 'required',
            'lokasi_kegiatan'   => 'required',
        ]);


        if ($validate) {
            $user_data = Auth::user();
            $filename = null;
            $tahun = date('Y');
            $kode_kegiatan = Str::random(4) . '-' . Str::random(4);
            if ($request->file('file_undangan')) {
                $file = $request->file('file_undangan');

                $file_extension = $file->getClientOriginalExtension();
                $filename = "file_undangan_" . time() . '.' . $file_extension;

                // Upload file
                $path = $request->file('file_undangan')->storeAs( 'public/'.$tahun.'/'.$kode_kegiatan.'/undangan', $filename);
                $filename = $path;
            }
            // else {
            //     $filename = 'NA';
            // }

            $arr_explode_satker = explode("#", $request->parameter_satker);
            $insert_kegiatan = MstKegiatan::create([
                'judul_kegiatan'      => $request->judul_kegiatan,
                'deskripsi_kegiatan'        => $request->deskripsi,
                'tgl_mulai'        => $request->tgl_mulai,
                'tgl_selesai'        => $request->tgl_selesai,
                'lokasi_kegiatan'            => $request->lokasi_kegiatan,
                'satuan_kerja_id' =>   $arr_explode_satker[0],
                'satuan_kerja_text' =>   $arr_explode_satker[1],
                'file_undangan'  => $filename,
                'slug'  =>  time() . "-" . Str::slug($request->judul_kegiatan, '-'),
                'kode_kegiatan'  => $kode_kegiatan,
                'jenis_kegiatan' =>  $request->jenis_kegiatan,
                'moderator' =>  $request->moderator,
                'is_narsum' => 0,
                'usernameintra'  => $user_data->usernameintra,
                'created_by'  => $user_data->usernameintra,
                'user_id'  => $user_data->id,

            ]);

            return redirect(route('kegiatan'))->with('success', 'Kegiatan berhasil ditambahkan');
        } else {
            // return redirect(route('backend.kegiatan.create'));
            return redirect(route('kegiatan-create'));
        }
    }
    public function edit($id)
    {
        $title = "Kegiatan - Ku";
        $data_satker = AuthSSO::getSatuanKerja();
        $arr_satker = array();
        foreach ($data_satker->data as $item_satker) {
            $arr_satker[$item_satker->id . "#" . $item_satker->name] = $item_satker->name;
        }

        $data_kegiatan = MstKegiatan::where('id', $id)->first();

        $token = AuthSSO::getSessionToken();
        $roleData = Cache::get($token . '#roleUserIntra');
        $userData = AuthSSO::getUserData($token);
        $role = 'user';

        if($roleData != null){
            if(array_key_exists(env('ROLE_SUPER_ADMIN'), $roleData)){
                $role = 'admin';
                // Boleh Semua
                return view('backend.kegiatan.edit', compact('data_kegiatan', 'title', 'arr_satker', 'role'));
            }elseif(array_key_exists(env('ROLE_PENGELOLA_SATKER'), $roleData)){
                // Jika yang satker_id nya sama boleh Edit
                if($userData['pegawaiData']['administrative_unit'] == $data_kegiatan->satuan_kerja_id){
                    $role = 'admin';
                    return view('backend.kegiatan.edit', compact('data_kegiatan', 'title', 'arr_satker', 'role'));
                }
                return redirect()->route('admin-daftar-hadir.list-all');

            }
        }

        // Jika yang Dirinya sendiri yang buat boleh Edit username_intra
        if($userData['pegawaiData']['username_intra'] == $data_kegiatan->created_by){
            return view('backend.kegiatan.edit', compact('data_kegiatan', 'title', 'arr_satker', 'role'));
        }else{
            return redirect()->route('kegiatan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'judul_kegiatan' => 'required',
            'parameter_satker'   => 'required',
            'tgl_mulai'   => 'required',
            'tgl_selesai'   => 'required',
            'lokasi_kegiatan'   => 'required'
        ]);

        if ($validate) {
            // $user_data = Auth::user();
            $tahun = date('Y');
            $filename = null;
            $data_mst_kegiatan = MstKegiatan::where('id', $id)->first();
            if ($request->file('file_undangan')) {
                $file = $request->file('file_undangan');

                $file_extension = $file->getClientOriginalExtension();
                $filename = "file_undangan" . time() . '.' . $file_extension;

                $path = $request->file('file_undangan')->storeAs( 'public/'.$tahun.'/'.$data_mst_kegiatan->kode_kegiatan.'/undangan', $filename);
                $filename = $path;

                // // Upload file
                // $path = $request->file('file_undangan')->storeAs('website/undangan', $filename);
                // $filename = $path;
            }


            $arr_explode_satker = explode("#", $request->parameter_satker);
            $data_mst_kegiatan->judul_kegiatan     = $request->judul_kegiatan;
            $data_mst_kegiatan->jenis_kegiatan     = $request->jenis_kegiatan;
            $data_mst_kegiatan->deskripsi_kegiatan   = $request->deskripsi;
            $data_mst_kegiatan->tgl_mulai        = $request->tgl_mulai;
            $data_mst_kegiatan->tgl_selesai       = $request->tgl_selesai;
            $data_mst_kegiatan->moderator      = $request->moderator;
            $data_mst_kegiatan->lokasi_kegiatan            = $request->lokasi_kegiatan;
            $data_mst_kegiatan->satuan_kerja_text           = $arr_explode_satker[1];
            $data_mst_kegiatan->satuan_kerja_id             =  $arr_explode_satker[0];
            $data_mst_kegiatan->file_undangan  = $filename;
            $data_mst_kegiatan->save();

            if ($request->role == 'admin') {
                # code...
                return redirect(route('admin-daftar-hadir.list-all'))->with('success', 'Kegiatan berhasil diperbarui');
            }else{
                return redirect(route('kegiatan'))->with('success', 'Kegiatan berhasil diperbarui');
            }

        } else {
            return redirect(route('kegiatan-edit'));
        }
    }
    public function destroy(Request $request)
    {
        //
        $code = '200';
        $status = 'OK';
        $message = '';
        $data = '';

        $data_kegiatan = MstKegiatan::destroy($request->id);


        $call_back = array(
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' =>  $data_kegiatan
        );

        $json_encode = json_encode($call_back);

        echo $json_encode;
    }
    public function cetak_lengkap($id)
    {
        
        

        $data_kegiatan = MstKegiatan::where('id', '=', $id)->first();
        $data_peserta_kegiatan = TrxPeserta::with('mst_kegiatan')->where('mst_kegiatan_id', '=', $id)->get();

        if(env('PDF_DEBUG')) {
            return view('backend/kegiatan/cetak', compact('data_peserta_kegiatan', 'data_kegiatan'));
        }

        $view = \View::make('backend/kegiatan/cetak', compact('data_peserta_kegiatan', 'data_kegiatan'));
        $html_content = $view->render();
        PDF::SetTitle('Laporan daftar hadir ' . $data_kegiatan->judul_kegiatan);
        PDF::SetMargins(1, 1, 1, true);
        PDF::AddPage();

        PDF::writeHTML($html_content, true, false, true, false, '');
        // D is the change of these two functions. Including D parameter will avoid
        // loading PDF in browser and allows downloading directly
        PDF::Output(time() . '_Laporan_daftarhadir.pdf', 'I');
    }
    public function cetak($id)
    {
        
        

        $data_kegiatan = MstKegiatan::where('id', '=', $id)->first();
        $data_peserta_kegiatan = TrxPeserta::with('mst_kegiatan')->where('mst_kegiatan_id', '=', $id)->get();

        if(env('PDF_DEBUG')) {
            return view('backend/kegiatan/cetak_daftar_hadir', compact('data_peserta_kegiatan', 'data_kegiatan'));
        }

        $view = \View::make('backend/kegiatan/cetak_daftar_hadir', compact('data_peserta_kegiatan', 'data_kegiatan'));
        $html_content = $view->render();
        PDF::SetTitle('Laporan daftar hadir ' . $data_kegiatan->judul_kegiatan);
        PDF::SetMargins(1, 1, 1, true);
        PDF::AddPage();

        PDF::writeHTML($html_content, true, false, true, false, '');
        // D is the change of these two functions. Including D parameter will avoid
        // loading PDF in browser and allows downloading directly
        PDF::Output(time() . '_Laporan_daftarhadir.pdf', 'I');
    }

    public function list_peserta($kegiatan_id){

        $kegiatan = MstKegiatan::where('id', $kegiatan_id)->first();
        $data_peserta_kegiatan = TrxPeserta::where('mst_kegiatan_id',  $kegiatan_id)->get();

        return view('backend/kegiatan/list_peserta', compact('kegiatan', 'data_peserta_kegiatan'));
    }
}
