<?php

namespace App\Services;

use App\Models\Cidade;
use Illuminate\Support\Facades\Cache;

class CidadeService
{
    public static function cacheCidades()
    {
        return Cache::rememberForever('cidades', function () {
            return Cidade::all();
        });
    }
}
