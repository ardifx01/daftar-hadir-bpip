<?php

namespace App\Http\Controllers;

use App\Models\MstKegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MstKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $insert_mst_kegiatan = MstKegiatan::firstOrCreate([
            'kode_kegiatan' => '000',
            'jenis_kegiatan' => 'Internal',
            'judul_kegiatan' => 'Judul Kegiatan',
            'deskripsi_kegiatan' => 'Deskripsi Kegiatan',
            'tgl_mulai' => Carbon::now(),
            'tgl_selesai' => Carbon::now(),
            'lokasi_kegiatan' => 'Zoom',
            'file_undangan' => '-',
            'slug' => 'judul-kegiatan',
            'is_narsum' => TRUE,
            'satuan_kerja_id' => '1',
            'satuan_kerja_text' => 'Satuan Kerja',
            'usernameintra' => 'farh002',
            'created_by' => 'farh002',
            'user_id' => 1
        ]);
    }

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
}
