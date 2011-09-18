<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Tracker_Tickets_Update extends Abstract_View_Page_Project {

	public function form()
	{
		$yform = YForm::factory()
			->add_values( (array) $this->values)
			->add_messages('errors', (array) $this->errors);

		return array(
			'open'    => $yform->open($this->request->uri()),
			'comment' => $yform->textarea('comment'),
			'submit'  => $yform->submit('update'),
			'close'   => $yform->close(),
		);
	}
}