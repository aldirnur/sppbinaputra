<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetodePembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code');
            $table->string('nama');
            $table->smallInteger('type')->comment('1. Dompet Digital, 2. Bank Transfer')->default(1);
            $table->timestamps();
        });
        Schema::table('transaksi', function (Blueprint $table) {
            $table->integer('metode_pembayaran_id')->nullable()->after('tag_id');
            $table->integer('id_siswa')->nullable()->after('metode_pembayaran_id');
            $table->dateTime('expired_token')->nullable()->after('token');
            $table->dateTime('expired_pembayaran')->nullable()->after('expired_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
