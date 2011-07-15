<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Projects_Home extends Abstract_View_Page {

	public function project()
	{
		return $this->project->document();
	}
}