<?php

namespace App\Http\Controllers\be;

use App\Http\Classes\AuthSSO;
use App\Http\Controllers\Controller;
use App\Models\MstKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminDaftarHadirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $token = AuthSSO::getSessionToken();
    }

    public function index()
    {
        //
        $token = AuthSSO::getSessionToken();

        $roleData = Cache::get($token . '#roleUserIntra');
        dd($roleData);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list_all($param = null){
        $token = AuthSSO::getSessionToken();

        $roleData = Cache::get($token . '#roleUserIntra');
        //dd($roleData);
        $userData = AuthSSO::getUserData($token);

        if(!$userData){
            redirect(route('beranda'));
        }

        if($param == null){
            if(array_key_exists(env('ROLE_SUPER_ADMIN'), $roleData)){
                $getSatuanKerja = AuthSSO::getSatuanKerja();
                foreach ($getSatuanKerja->data as $key => $value) {
                    $arr_satuan_kerja[$value->id] = $value->name;
                }
                $satuan_kerja_id = $param;
            }else{
               $arr_satuan_kerja[$userData['pegawaiData']['administrative_unit']] = $userData['pegawaiData']['administrative_name'];
               $satuan_kerja_id = $userData['pegawaiData']['administrative_unit'];
            }
        }else{
            if(array_key_exists(env('ROLE_SUPER_ADMIN'), $roleData)){
                $getSatuanKerja = AuthSSO::getSatuanKerja();
                foreach ($getSatuanKerja->data as $key => $value) {
                    $arr_satuan_kerja[$value->id] = $value->name;
                }
                $satuan_kerja_id = $param;
            }else{
               $arr_satuan_kerja[$userData['pegawaiData']['administrative_unit']] = $userData['pegawaiData']['administrative_name'];
               $satuan_kerja_id = $userData['pegawaiData']['administrative_unit'];
            }
        }

        // Get Data;
        $data_kegiatan = MstKegiatan::withCount('trx_peserta')->where('deleted_at', null)->orderBy('created_at', 'desc')->where('satuan_kerja_id', '=', $satuan_kerja_id)->get();

        return view('backend.admin_daftar_hadir.list', compact('data_kegiatan', 'arr_satuan_kerja', 'satuan_kerja_id'));


    }
}
