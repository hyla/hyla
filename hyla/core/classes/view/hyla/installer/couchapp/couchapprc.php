<?php defined('SYSPATH') or die('No direct script access.');

class View_Hyla_Installer_CouchApp_CouchAppRC extends Kostache {

	public $config;

	public function db()
	{
		return 'http://'.$this->config['host'].':'.$this->config['port'].'/'.$this->config['db'];
	}

	public function save_path()
	{
		return APPPATH.'media/couchapp/.couchapprc';
	}
}