<?php  namespace Softjob\Services;


class AuthService {

	static $loggedInUser;

	/**
	 * Get currently logged in user
	 *
	 * @return bool
	 */
	public function getUser()
	{
		return self::$loggedInUser;
	}

	/**
	 * Set currently logged in user
	 *
	 * @param $userId
	 */
	public function setUser($userId)
	{
		self::$loggedInUser = $userId;
	}
}