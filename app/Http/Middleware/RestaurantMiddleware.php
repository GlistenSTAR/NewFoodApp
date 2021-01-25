<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class RestaurantMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (Auth::check()) {
			if (Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2) {
				return $next($request);
			} else {
				Auth::logout();
				return redirect(url(''));
			}
		} else {
			Auth::logout();
			return redirect(url(''));
		}
	}
}
