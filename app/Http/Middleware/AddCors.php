<?php namespace Softjob\Http\Middleware;

use Closure;
use Config;
use Illuminate\Contracts\Routing\Middleware;
use Softjob\Repositories\UserRepoInterface;
use Softjob\Services\AuthService;


class AddCors implements Middleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next )
	{
		/*$headers = [
			'Access-Control-Allow-Origin' => '*',
			'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
			'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
		];

		if($request->getMethod() == "OPTIONS") {
			return Response::make('OK', 200, $headers);
		}*/
		$response = $next($request);
		$this->setCorsHeader( $response );
		return $response;
	}

	/**
	 * @param $response
	 */
	public function setCorsHeader( $response )
	{
		$response->headers->set( 'Access-Control-Allow-Origin', Config::get( 'app.url' ) );
	}
}
