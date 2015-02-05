<?php namespace Softjob\Handlers\Commands;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use Softjob\Commands\LoginUserCommand;

use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Softjob\Contracts\Repositories\UserRepoInterface;

class LoginUserCommandHandler {

	/**
	 * @var UserRepoInterface
	 */
	private $userRepo;

	/**
	 * Create the command handler.
	 *
	 * @param UserRepoInterface $userRepo
	 */
	public function __construct(UserRepoInterface $userRepo)
	{
		//
		$this->userRepo = $userRepo;
	}

	/**
	 * Handle the command.
	 *
	 * @param  LoginUserCommand  $command
	 * @return void
	 */
	public function handle(LoginUserCommand $command)
	{
		if(! $this->userRepo->checkUsernameAndPassword($command->username, $command->password)) {
			throw new \InvalidArgumentException("Invalid username and/or password");
		}

		$user = $this->userRepo->getUserByUsername($command->username);
		$data = [
			'sub' => 'User',
			'iss' => $user->id,
			'iat' => time(),
			'exp' => time()+1296000,
		];

		return [
			'token' => \JWT::encode($data, \Config::get('app.key')),
		    'user' => $user
		];
	}

}
