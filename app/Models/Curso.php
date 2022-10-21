<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $casts = [
        'data' => 'array'
    ];

    protected $table = 'cursos';
    protected $fillable = [
        'nome',
        'data',
        'referencia',
        'id_certificado'
    ];

    public function relCertificado()
    {
        return $this->hasOne('App\Models\Certificado');
    }
}
