<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Policy class to determine if the user can create tickets
 *
 * @package   Hyla
 * @author    Lorenzo Pisani <zeelot3k@gmail.com>
 * @copyright (c) 2011 Lorenzo Pisani
 */
class Policy_CreateTicket extends Policy {

	/**
	 * Method to execute the policy
	 *
	 * @param Model_ACL_User $user  the user account to run the policy on
	 * @param array          $extra an array of extra parameters that this policy
	 *                       can use
	 *
	 * @return Boolean
	 */
	public function execute(Model_ACL_User $user, array $extra = NULL)
	{
		return $user->loaded();
	}
}