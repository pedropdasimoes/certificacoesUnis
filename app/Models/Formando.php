<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formando extends Model
{
    use HasFactory;
    protected $casts = [
        'cursos' => 'array',
        'redes' => 'array',
        'badges' => 'array'
    ];

    protected $table = 'formandos';
    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'cursos',
        'redes',
        'badges',
        'password',
        'profile_photo_path'
    ];
}
