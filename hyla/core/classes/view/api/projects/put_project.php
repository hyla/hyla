<?php defined('SYSPATH') or die('No direct script access.');

class View_API_Projects_Put_Project extends Abstract_View_API {

	public function ok()
	{
		return TRUE;
	}

	public function project()
	{
		return $this->project->document();
	}
}