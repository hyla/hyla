<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Projects_Create extends Abstract_View_Page {

	public function form()
	{
		$yform = YForm::factory()
			->add_values( (array) $this->values)
			->add_messages('errors', (array) $this->errors);

		return array(
			'open'        => $yform->open($this->request->uri()),
			'name'        => $yform->text('name'),
			'slug'        => $yform->text('slug'),
			'description' => $yform->textarea('description'),
			'submit'      => $yform->submit('create'),
			'close'       => $yform->close(),
		);
	}
}