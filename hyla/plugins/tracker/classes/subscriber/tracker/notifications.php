<?php defined('SYSPATH') or die('No direct script access.');

class Subscriber_Tracker_Notifications implements Interface_Subscriber {

	public function get_listeners()
	{
		return array(
			'hyla:account-settings.notifications-form' => array($this, 'notifications_form'),
		);
	}

	/**
	 * Adds tracker related items to the sub navigation of a project.
	 *
	 * @param  Interface_Event  $event the event object
	 * @return void
	 */
	public function notifications_form(Interface_Event $event)
	{
		// The current form data array
		$data = &$event->get_subject();

		$form = Arr::get($event->get_arguments(), 'form');

		$data['notifications'][] = array(
			'name'        => 'Ticket Create',
			'description' => 'Triggered when a ticket is created in any of your projects.',
			'notifiers'   => array(
				array(
					'notifier' => $form->checkbox('notification-settings[ticket-create][email]')
						->set_label('Email'),
				),
			),
		);
	}
}