<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('jabatan')->nullable();
            $table->string('nip', '20')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('golongan')->nullable();
            $table->string('satuan_kerja')->nullable();
            $table->string('instansi')->nullable();
            $table->string('telepon')->nullable();
            $table->tinyInteger('is_eksternal')->nullable()->comment = '1 if eksternal';
            $table->tinyInteger('tipe_user')->nullable()->default('1')->comment = '1 PNS 2 Non PNS';
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->softDeletes();
            $table->dropColumn('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('jabatan');
            $table->dropColumn('nip');
            $table->dropColumn('pangkat');
            $table->dropColumn('golongan');
            $table->dropColumn('satuan_kerja');
            $table->dropColumn('instansi');
            $table->dropColumn('telepon');
            $table->dropColumn('is_eksternal');
            $table->dropColumn('tipe_user');
            $table->dropColumn('access_token');
            $table->dropColumn('refresh_token');
            $table->dropColumn('deleted_at');
            $table->string('password');
        });
    }
}
