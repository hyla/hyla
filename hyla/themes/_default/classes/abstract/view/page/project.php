<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains methods useful to project pages
 *
 * @package    Hyla
 * @category   Kostache
 * @author     Synapse Studios
 */
abstract class Abstract_View_Page_Project extends Abstract_View_Page {

	public function sub_navigation()
	{
		$navigation = array();
		$arguments = array('project' => $this->project);

		// Trigger this event so plugins can alter the navigation before it's rendered
		$this->dispatcher->trigger('hyla:project.sub-nav', new Event($navigation, $arguments));

		return $navigation;
	}
}