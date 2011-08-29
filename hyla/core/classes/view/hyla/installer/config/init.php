<?php defined('SYSPATH') or die('No direct script access.');

class View_Hyla_Installer_Config_Init extends Kostache {

	public $base_url;
	public $index_file;
	public $charset;
	public $cache_dir;
	public $errors;
	public $profile;
	public $caching;

	public function required_input()
	{
		return array(
			'base_url'   => array(
				'line'    => 'Base URL [http://dev.vm/hyla/]',
				'default' => 'http://dev.vm/hyla/',
			),
			'index_file' => array(
				'line'    => 'Index File [FALSE]',
				'default' => FALSE,
			),
			'charset'    => array(
				'line'    => 'Charset [utf-8]',
				'default' => 'utf-8',
			),
			'cache_dir'  => array(
				'line'    => 'Cache Dir [APPPATH.\'cache\']',
				'default' => 'APPPATH.\'cache\'',
			),
			'errors'     => array(
				'line'    => 'Errors [TRUE]',
				'default' => 'TRUE',
			),
			'profile'    => array(
				'line'    => 'Profile [FALSE]',
				'default' => 'FALSE',
			),
			'caching'    => array(
				'line'    => 'Caching [FALSE]',
				'default' => 'FALSE',
			),
		);
	}

	public function save_path()
	{
		return APPPATH.'config/init.php';
	}
}