<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains methods useful to pages
 *
 * @package    Hyla
 * @category   Kostache
 * @author     Synapse Studios
 */
abstract class View_Page extends View_Layout {

	// The Page Title
	public $title = NULL;

	public function i18n()
	{
		return function($string)
		{
			return __($string);
		};
	}

	public function _initialize()
	{
		Assets::add_group('default-template');
		parent::_initialize();
	}

	public function title()
	{
		return $this->title;
	}

	public function profiler()
	{
		return View::factory('profiler/stats');
	}
}
