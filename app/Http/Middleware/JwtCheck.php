<?php namespace Softjob\Http\Middleware;

use Closure;
use Softjob\Services\AuthService;

class JwtCheck {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next )
	{
		$token = str_replace('Bearer ', '', $request->header('Authorization'));
		if ( ! $this->checkToken($token)) {
			$response = \Response::json([
				'status'  => 'error',
				'message' => 'Unautherized request'
			], 403);

			return $response;
		}
		$response = $next($request);

		return $response;
	}

	/**
	 * @param $token
	 *
	 * @return bool
	 */
	private function checkToken( $token )
	{
		$user = \App::make('Softjob\Contracts\Repositories\UserRepoInterface');

		try {
			$data = \JWT::decode($token, \Config::get('app.key'));
		} catch (\Exception $e) {
			return false;
		}

		if ($user->getUser($data->iss) == false) {
			return false;
		}

		$auth = new AuthService();
		$auth->setUser($data->iss);

		return true;
	}

}
