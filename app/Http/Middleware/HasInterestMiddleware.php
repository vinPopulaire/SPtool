<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;
class HasInterestMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{


		//if ($request->is('profile'))
		//{
		if (count(Auth::user()->mecanex_user->interest)>0) {
			return Redirect::route('interest.edit');
		}
		//}

		return $next($request);
	}

}
