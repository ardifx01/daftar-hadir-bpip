<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxPeserta extends Model
{
    use HasFactory;

    protected $table = "trx_peserta";
    protected $guarded = [];
    public function mst_kegiatan()
    {
        return $this->belongsTo(MstKegiatan::class);
    }
}
