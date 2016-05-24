<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Entrust;

class permissions {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		if(Entrust::hasRole(['Admin','Project Manager','Project Lead'])){
		return $next($request);
	}
		else return view('app')->with('permissionerror',"You don't have permission to access this page");
	}

}
