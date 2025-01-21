<?php

namespace App\Models;

use App\Enums\EventoStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => EventoStatusEnum::class,
        'data_hora' => 'datetime:Y-m-d H:i',
    ];

    public function artista()
    {
        return $this->belongsTo(Artista::class);
    }

    public function contratante()
    {
        return $this->belongsTo(Contratante::class);
    }

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function historico()
    {
        return $this->hasMany(EventoHistorico::class);
    }

    public function observacoes()
    {
        return $this->hasMany(EventoObservacao::class);
    }

    public function servicos()
    {
        return $this->hasMany(EventoServico::class);
    }
}
