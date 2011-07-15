<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Main_Home extends Abstract_View_Page {

	public function pages()
	{
		return array(
			'projects' => Route::url('hyla/projects'),
		);
	}
}