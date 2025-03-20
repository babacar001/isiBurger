<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
/**
* Handle an incoming request.
*
* @param $request
* @param $next
* @param $role
* @return mixed
*/
public function handle($request, $next, $role)
{
if (!Auth::check() || !Auth::user()->hasRole($role)) {
// Redirigez ou retournez une réponse d'erreur
return redirect('/'); // ou une autre route
}

return $next($request);
}
}
