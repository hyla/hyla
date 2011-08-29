http://dev.vm:5984/hyla
<?php defined('SYSPATH') or die('No direct script access.');

class View_Hyla_Installer_CouchApp_CouchAppRC extends Kostache {

	public $config;

	public function db()
	{
		return 'http://'.$this->config['host'].':'.$this->config['port'].'/'.$this->config['db'];
	}

	public function save_path()
	{
		return HYLAPATH.'core/couchapp/.couchapprc';
	}
}