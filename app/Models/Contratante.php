<?php

namespace App\Models;

use App\Observers\ContratanteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ContratanteObserver::class])]
class Contratante extends Model
{
    use HasFactory;

    protected $table = 'contratantes';

    protected $guarded = [];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function representanteLegalCidade()
    {
        return $this->hasOne(Cidade::class, 'id', 'representante_legal_cidade_id');
    }
}
