<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPangkatGolonganJabatanToTrxPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trx_peserta', function (Blueprint $table) {

            $table->string('pangkat')->nullable();
            $table->string('golongan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trx_peserta', function (Blueprint $table) {

            $table->dropColumn('pangkat');
            $table->dropColumn('golongan');
        });
    }
}
