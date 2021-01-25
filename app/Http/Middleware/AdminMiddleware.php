<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class AdminMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (Auth::check()) {
			if (Auth::user()->is_admin == 1) {
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
