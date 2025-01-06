<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoInterno extends Model
{
    use HasFactory;

    protected $table = 'documentos_internos';

    protected $guarded = [];
}
