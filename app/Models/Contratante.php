<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
