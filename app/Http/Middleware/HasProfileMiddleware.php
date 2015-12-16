<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;

class HasProfileMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	 
	 /*
	 An xristis den exei profile tote ton paei na dimiourgisei
	 */
	public function handle($request, Closure $next)
	{
		$profile=Auth::user()->mecanex_user;
		//if ($request->is('profile'))
		//{
			if (count($profile)==0) {
				return Redirect::route('profile.create');
			}
		//}
		return $next($request);
	//}

}
}
