<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comentario extends Model
{
    protected $table = 'comentario';
    protected $fillable = ['noticia_id', 'mensaje', 'valoracion'];
    public function noticia(): BelongsTo
    {
        return $this->belongsTo(Noticia::class, 'noticia_id');
    }
}
