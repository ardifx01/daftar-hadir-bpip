<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxMateri extends Model
{
    use HasFactory;

    protected $table = "trx_materi";
    protected $guarded = [];
}
