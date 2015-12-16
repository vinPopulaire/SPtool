<?php namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Auth;
//use Illuminate\Cookie\Middleware;
//use Illuminate\Foundation\Http\Middleware;
//use Illuminate\Session\Middleware;
//use Illuminate\View\Middleware;

use Illuminate\Support\Facades\Config;


class ApiRequest
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */

		function handle($request, Closure $next)
		{
			\Config::set('session.driver', 'array');
			return $next($request);
		}
}

