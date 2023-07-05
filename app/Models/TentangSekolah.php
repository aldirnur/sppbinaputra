<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TentangSekolah extends Model
{
    use HasFactory;
    protected $table = 'tentang_sekolah';
    protected $primaryKey = 'id_tentang';

    protected $fillable = ['id_tentang','nama_intansi','status_akreditasi','email', 'link', 'alamat_instansi', 'yayasan','kepala_sekolah','email','nip_kepala_sekolah'];
}
