<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id','nama_kelas', 'type'
    ];

    public function siswa(){
        return $this->hasMany(Siswa::class, 'kelas');
    }
}
