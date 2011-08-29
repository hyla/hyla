<?php defined('SYSPATH') or die('No direct script access.');

class View_Hyla_Installer_HTAccess extends Kostache {

	public $base_url;

	public function rewrite_base()
	{
		return parse_url($this->base_url, PHP_URL_PATH);
	}

	public function save_path()
	{
		return DOCROOT.'.htaccess';
	}
}