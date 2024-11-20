<?php

namespace App\Models;

use App\Enums\EventoStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoHistorico extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status_anterior' => EventoStatusEnum::class,
        'status_atual' => EventoStatusEnum::class,
    ];
}
