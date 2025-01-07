<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoInterno extends Model
{
    use HasFactory;

    protected $table = 'documentos_internos';

    protected $guarded = [];

    public function artista()
    {
        return $this->belongsTo(Artista::class);
    }

    public function categoria()
    {
        return $this->belongsTo(DocumentoInternoCategoria::class);
    }
}
