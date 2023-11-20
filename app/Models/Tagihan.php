<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    // use HasFactory;

    protected $table = 'tagihan';
    protected $primaryKey = 'tag_id';
    protected $fillable = [
        'id_tagihan','jumlah','id_siswa','id_spp','bulan'
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function spp(){
        return $this->belongsTo(Spp::class, 'id_spp');
    }
}
