<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Noticia extends Model
{
    protected $table = 'noticia';

    protected $fillable = ['titulo','texto', 'resumen'];
    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'noticia_id');
    }
}
