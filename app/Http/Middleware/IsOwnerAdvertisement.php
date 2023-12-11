<?php

namespace App\Http\Middleware;

use App\Models\Advertisement;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOwnerAdvertisement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Advertisement $advertisement */
        $advertisement = $request->route('advertisement');
        abort_if(! auth()->user()->isOwnerOf($advertisement), 403);

        return $next($request);
    }
}
