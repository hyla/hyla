<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Policy class to determine if the user can delete tickets
 *
 * @package   Hyla
 * @author    Lorenzo Pisani <zeelot3k@gmail.com>
 * @copyright (c) 2011 Lorenzo Pisani
 */
class Policy_DeleteTicket extends Policy {

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
		if ( ! $user->loaded())
			return FALSE;

		// Only Admin or ticket author are allowed to delete tickets
		if ($user->is('admin') OR $user->get('_id') == $extra['ticket']->get('created_by'))
			return TRUE;

		return FALSE;
	}
}