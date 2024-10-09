<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SimulateRealNetwork
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sleep_time = rand(0, 30) / 10; # 3seg max de espera
        if ($sleep_time < 1) usleep($sleep_time);
        else sleep($sleep_time);

        return $next($request);
    }
}
