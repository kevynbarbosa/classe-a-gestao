<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function artista()
    {
        return $this->belongsTo(Artista::class);
    }

    public function contratante()
    {
        return $this->belongsTo(Contratante::class);
    }
}
