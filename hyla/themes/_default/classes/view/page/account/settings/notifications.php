<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Account_Settings_Notifications extends Abstract_View_Page_Account_Settings {

	// Form properties
	public $errors = array();
	public $values = array();

	public function form()
	{
		$form = YForm::factory()
			->add_messages('error', (array) $this->errors)
			->add_values( (array) $this->values);

		// Auto Populate the forms
		foreach ($this->auth->get('notification-settings', array()) as $notification => $notifiers)
		{
			foreach ($notifiers as $notifier)
			{
				$form->add_values(array(
					'notification-settings' => array(
						$notification => array(
							$notifier => TRUE,
						),
					),
				));
			}
		}

		return array(
			'open'          => $form->open($this->request->uri()),
			'notifications' => array(
				array(
					'name'        => 'Project Create',
					'description' => 'Triggered when a new project is created.',
					'notifiers'   => array(
						array(
							'notifier' => $form->checkbox('notification-settings[project-create][email]')
								->set_label('Email'),
						),
					),
				),
			),
			'submit'        => $form->submit('save'),
			'close'         => $form->close(),
		);
	}
}