<?php

namespace App\Models;

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
}
