<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuzzy extends Model
{
    use HasFactory;

    protected $table = 'fuzzys';

    protected $fillable = [
        'keterangan',
        'operator',
        'nilai_start',
        'nilai_end',
        'nilai_persyaratan',
        'nilai_fuzzy',
        'id_kriteria',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}
