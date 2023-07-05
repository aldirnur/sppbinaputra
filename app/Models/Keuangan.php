<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'kas';
    protected $primaryKey = 'id_kas';

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'trans_id');
    }
}
