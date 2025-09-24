<?php

namespace App\Http\Controllers\be;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MstKegiatan;
use App\Models\TrxPeserta;
use App\Http\Classes\AuthSSO;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
    }

    public function index()
    {
        $token = AuthSSO::token();
        $user_data = Cache::store('redis')->get($token . "#user");

        if(!$user_data){
            redirect(route('beranda'));
        }

        //dd(Cache::has($token."#user"));
        $data_kegiatan = MstKegiatan::where('deleted_at', null)->where('created_by', '=', $user_data->usernameintra)->count();
        $data_list_daftar_hadir = TrxPeserta::with('mst_kegiatan')->where('created_by', '=', $user_data->usernameintra)->count();
        $data_peserta = DB::table('trx_peserta')
            ->join('mst_kegiatan', 'trx_peserta.mst_kegiatan_id', '=', 'mst_kegiatan.id')
            ->select('trx_peserta.mst_kegiatan_id', 'mst_kegiatan.created_by')->where('mst_kegiatan.created_by', '=', $user_data->usernameintra)
            ->count();

        return view('backend.dashboard', compact('data_kegiatan', 'data_list_daftar_hadir', 'data_peserta'));
    }
}
