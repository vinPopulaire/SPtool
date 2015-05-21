<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	//added for avoiding csrf
	/*It doesn't work ....
        private $openRoutes = ['mecanexuser'];

        public function handle($request, Closure $next)
        {
            //check if requested oath in within the openRoutes array
            if (in_array($request->path(), $this->openRoutes)) {
                return $next($request);
            } else {
                return parent::handle($request, $next);
            }

        }


    }
    */

	public function handle($request, Closure $next)
	{
		if (!$request->is('api/*')) {
			return parent::handle($request, $next);
		}

		return $next($request);
	}
}