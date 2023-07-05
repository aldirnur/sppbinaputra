<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    // use HasFactory;

    protected $table = 'spp';
    protected $primaryKey = 'id_spp';
    protected $fillable = [
        'id_spp','tahun_ajaran', 'nominal_spp'
    ];
}
