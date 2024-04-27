<?php

namespace App\Models;

use App\MetodePembayaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    // use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'trans_id';

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function tagihan(){
        return $this->belongsTo(Tagihan::class, 'tag_id');
    }

    public function metodePembayaran() {
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id' , 'id');
    }

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function getJumlahBulan($tag_id, $nominal) {
        $tagihan = Tagihan::where('tag_id', $tag_id)->first();

        $jumlahBulan = 0;
        if ($tagihan) {
            $nominal_tagihan = (isset($tagihan->spp->nominal_spp) ? $tagihan->spp->nominal_spp : 0) * $tagihan->jumlah;
            $sisa_tagihan = ($nominal_tagihan - $nominal ) / $tagihan->spp->nominal_spp;
            $jumlahBulan = $tagihan->jumlah - $sisa_tagihan;
        }
        return $jumlahBulan;
    }

    public function getSisaTagihan($tag_id, $nominal) {
        $tagihan = Tagihan::where('tag_id', $tag_id)->first();

        $jumlahBulan = 0;
        if ($tagihan) {
            $sisa_tagihan = (isset($tagihan->spp->nominal_spp) ? $tagihan->spp->nominal_spp : 0) * $tagihan->jumlah;
        }
        return $sisa_tagihan;
    }
}
