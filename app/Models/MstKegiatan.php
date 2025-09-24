<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstKegiatan extends Model
{
    use HasFactory;

    protected $table = "mst_kegiatan";
    protected $guarded = [];
    public function trx_peserta()
    {
        return $this->hasMany(TrxPeserta::class);
    }
}
