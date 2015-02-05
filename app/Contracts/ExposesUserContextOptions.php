<?php namespace Softjob\Contracts;

interface ExposesUserContextOptions {

	/**
	 * @param $userId
	 *
	 * @return array
	 */
	public function userContextOptions($userId);
}