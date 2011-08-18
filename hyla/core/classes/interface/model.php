<?php defined('SYSPATH') or die('No direct script access.');

interface Interface_Model {

	public function set($key, $value);
	public function get($key, $default);

}