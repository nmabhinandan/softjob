<?php  namespace Softjob\Http\Controllers;

use Softjob\Repositories\UserRepoInterface;

class UserController extends Controller {

	protected $user;

	function __construct(UserRepoInterface $user)
	{

		$this->user = $user;
	}

	public function avatar($id)
	{

	}
}