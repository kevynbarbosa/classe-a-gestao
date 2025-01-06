<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoInternoCategoria extends Model
{
    use HasFactory;

    protected $table = 'documentos_internos_categorias';

    protected $guarded = [];
}
