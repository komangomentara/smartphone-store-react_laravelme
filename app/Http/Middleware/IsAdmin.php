<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // hanya user dengan role admin yang boleh lewat
        abort_unless($request->user() && $request->user()->role === 'admin', 403, 'Khusus admin.');
        return $next($request);
    }
}
