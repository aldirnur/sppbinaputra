<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    // use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'jur_id';
    protected $fillable = [
        'jur_id','nama_jurusan', 'type'
    ];

    public function siswa(){
        return $this->hasMany(Siswa::class, 'id_jurusan');
    }
}
