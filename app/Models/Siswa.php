<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = ['id_siswa','nis','nisn','nama', 'jenis_kelamin', 'kelas', 'alamat','tgl_lahir','no_tlp','pin','nama_wali','agama','jur_id', 'angkatan'];

    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'jur_id');
    }
}
