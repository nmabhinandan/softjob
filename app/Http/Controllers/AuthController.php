<?php namespace Softjob\Http\Controllers;


use Illuminate\Http\Response;
use Softjob\Commands\LoginUserCommand;
use Softjob\Http\Requests\LoginRequest;

class AuthController extends Controller {

	protected $authService;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @internal param AuthService $authService
	 *
	 */
	public function __construct()
	{

	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param LoginRequest $request
	 *
	 * @return Response
	 */
	public function login( LoginRequest $request )
	{
		try {

			$data = $this->dispatchFrom(LoginUserCommand::class, $request);

			return Response::create([
				'status'  => 'success',
				'data'    => [
					'token'       => $data['token'],
					'user'        => $data['user'],
					'permissions' => $data['permissions']
				],
				'message' => 'You have successfully logged in'
			], 200);

		} catch (\InvalidArgumentException $e) {

			return Response::create([
				'status'  => 'error',
				'data'    => '',
				'message' => 'Invalid username or password'
			], 403);
		}
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return Response
	 */
	public function logout()
	{

	}

	/**
	 * Resend the confirmation email
	 *
	 * @return Response
	 */
	public function resend()
	{

	}
}
