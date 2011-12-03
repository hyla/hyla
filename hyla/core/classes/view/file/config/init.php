<?php defined('SYSPATH') or die('No direct script access.');

class View_File_Config_Init extends Abstract_View_File {

	public function filepath()
	{
		return APPPATH.'config/init.php';
	}

	public function profile()
	{
		return empty($this->values['profile'])
			? 'FALSE'
			: 'TRUE';
	}

	public function caching()
	{
		return empty($this->values['caching'])
			? 'FALSE'
			: 'TRUE';
	}
}