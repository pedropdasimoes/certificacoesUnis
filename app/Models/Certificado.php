<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;
    protected $casts = [
        'data' => 'array'
    ];

    protected $table = 'certificados';
    protected $fillable = [
        'nome',
        'data'
    ];

    public function relCurso()
    {
        return $this->hasMany('App\Models\Curso');
    }
}
