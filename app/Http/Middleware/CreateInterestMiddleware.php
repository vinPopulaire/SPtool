<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CreateInterestMiddleware
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$profile = Auth::user()->mecanex_user;


		if (count($profile) == 0) {
			return Redirect::route('profile.create')->with('message','You have to create your profile first');
		}
		//else tha prepei na petaei ajax oti prwta prepei na dimiourgiseis profile h na se paei sthn profile.create
		//}
		else {

			return $next($request);
		}

	}
}
