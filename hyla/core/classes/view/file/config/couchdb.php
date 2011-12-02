<?php defined('SYSPATH') or die('No direct script access.');

class View_File_Config_CouchDB extends Abstract_View_File {

	public function filepath()
	{
		return APPPATH.'config/couchdb.php';
	}
}