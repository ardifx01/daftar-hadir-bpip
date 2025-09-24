<?php

namespace App\Http\Controllers\be;

use App\Http\Controllers\Controller;
use App\Http\Classes\AuthSSO;
use Illuminate\Http\Request;
use App\Models\MstKegiatan;
use App\Models\TrxPeserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DaftarHadirController extends Controller
{
    //
    public function __construct()
    {
    }

    public function index()
    {
        $token = AuthSSO::token();
        $user_data = Cache::store('redis')->get($token . "#user");

        $data_list_daftar_hadir = TrxPeserta::with('mst_kegiatan')->where('created_by', '=', $user_data->usernameintra)->get();


        return view('backend.daftar_hadir.index', compact('data_list_daftar_hadir'));
    }
}
