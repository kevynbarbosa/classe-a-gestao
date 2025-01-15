<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoObservacao extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'evento_observacoes';
}
