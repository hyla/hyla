<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Installer_Database extends Abstract_View_Page {

	protected $_layout = 'layout/installer';

	public function home()
	{
		return Route::url('hyla/home');
	}
}