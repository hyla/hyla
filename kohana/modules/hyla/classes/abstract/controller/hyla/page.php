<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_Controller_Hyla_Page extends Abstract_Controller_Hyla_Base {

	protected function _request_view()
	{
		// Set default title and content views (path only)
		$directory = $this->request->directory();
		$controller = $this->request->controller();
		$action = $this->request->action();

		// Removes leading slash if this is not a subdirectory controller
		$controller_path = trim($directory.'/'.$controller.'/'.$action, '/');

		try
		{
			$view = Kostache::factory('page/'.$controller_path);
		}
		catch (Kohana_View_Exception $x)
		{
			/*
			 * The View class could not be found, so the controller action is
			 * repsonsible for making sure this is resolved.
			 */
			$view = NULL;
		}

		return $view;
	}
}