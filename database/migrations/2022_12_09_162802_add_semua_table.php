<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSemuaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->bigIncrements('id_siswa');
            $table->string('nis')->unique();
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->boolean('jenis_kelamin')->comment('1. Laki Laki, 2. Perempuan')->nullable();
            $table->integer('jur_id')->nullable();
            $table->string('kelas');
            $table->text('alamat');
            $table->date('tgl_lahir');
            $table->string('no_tlp');
            $table->string('nama_wali');
            $table->string('agama');
            $table->string('angkatan', 4);
            $table->timestamps();
        });

        Schema::create('kas', function (Blueprint $table) {
            $table->bigIncrements('id_kas');
            $table->date('tgl');
            $table->integer('trans_id');
            $table->string('nominal_kas')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Schema::create('kategori_keuangan', function (Blueprint $table) {
        //     $table->bigIncrements('id_kategori');
        //     $table->string('type')->comment('1. Pemasukan, 2. Pengeluaran');
        //     $table->string('nama_kategori');
        //     $table->timestamps();
        // });

        Schema::create('jurusan', function (Blueprint $table) {
            $table->Increments('jur_id');
            $table->string('nama_jurusan');
            $table->timestamps();
        });

        Schema::create('spp', function (Blueprint $table) {
            $table->increments('id_spp');
            $table->string('tahun_ajaran')->nullable();
            $table->string('nominal_spp')->nullable();
            $table->timestamps();
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('trans_id');
            $table->integer('tag_id')->nullable();
            $table->string('no_transaksi');
            $table->integer('nominal_transaksi');
            $table->date('tgl');
            $table->string('status_transaksi')->comment('1. Diterima, 2.Verifikasi, 3. Ditolak')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('bukti_transaksi');
            $table->integer('pm_id');
            $table->string('token')->nullable();
            $table->timestamps();
        });

        Schema::create('tagihan', function (Blueprint $table) {
            $table->bigIncrements('tag_id');
            $table->integer('id_siswa')->nullable();
            $table->integer('id_spp')->nullable();
            $table->double('jumlah');
            $table->boolean('status')->comment('1. Lunas 2. Belum Lunas')->nullable()->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('tagihan');
        Schema::dropIfExists('jurusan');
        Schema::dropIfExists('spp');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('kas');
        // Schema::dropIfExists('kategori_keuangan');?
    }
}
