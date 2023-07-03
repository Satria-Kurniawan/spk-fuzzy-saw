<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'criterias';

    protected $fillable = [
        'nama',
        'bobot',
        'is_benefit',
    ];

    public function fuzzy(){
        return $this->hasMany(Fuzzy::class);
    }
}
