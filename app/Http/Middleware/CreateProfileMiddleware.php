<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;

class CreateProfileMiddleware
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	 
	 /*  
	 An enas xristis patisei sto profilek exei dimiourgimeno tote ton paei sto profile. show wste na mhn ksanadimiourgisei 
	 
	 */
	public function handle($request, Closure $next)
	{
		$profile = Auth::user()->mecanex_user;


		//if ($request->is('profile'))
		//{
		if (count($profile) > 0) {
			return Redirect::route('profile.show');
		}
		//}
		return $next($request);
		//return Redirect::route('profile.create');
	}

}
