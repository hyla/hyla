<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains methods useful to project pages
 *
 * @package    Hyla
 * @category   Kostache
 * @author     Lorenzo Pisani - Zeelot
 */
abstract class Abstract_View_Page_Account_Settings extends Abstract_View_Page {

	public function sub_navigation()
	{
		$navigation = array(
			array(
				'url' => Route::url('hyla/account-settings', array(
					'action' => 'notifications',
				)),
				'text' => 'Notifications',
			),
		);
		$arguments = array('auth' => $this->auth);

		// Trigger this event so plugins can alter the navigation before it's rendered
		$this->dispatcher->trigger('hyla:account-settings.sub-nav', new Event($navigation, $arguments));

		return $navigation;
	}
}