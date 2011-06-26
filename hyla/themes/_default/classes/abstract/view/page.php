<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains methods useful to pages
 *
 * @package    Hyla
 * @category   Kostache
 * @author     Synapse Studios
 */
abstract class Abstract_View_Page extends Abstract_View_Layout {

	// The Page Title
	public $title = NULL;

	public function title()
	{
		return $this->title;
	}

	public function profiler()
	{
		return View::factory('profiler/stats');
	}
}
