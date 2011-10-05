<?php defined('SYSPATH') or die('No direct script access.');

class Subscriber_Tracker_Notifications implements Interface_Subscriber {

	public function get_listeners()
	{
		return array(
			'hyla:account-settings.notifications-form' => array($this, 'notifications_form'),
			'hyla:worker.notifier:model.ticket.create' => array($this, 'send_ticket_create_email'),
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

	public function send_ticket_create_email(Interface_Event $event)
	{
		// The id of the ticket
		$id = $event->get_subject();
		$di_container = Arr::get($event->get_arguments(), 'di_container');

		$ticket = $di_container->get('couch_model.ticket')
			->find($id);

		if ( ! $ticket->loaded())
			return; // Ticket must have been deleted before we could send notifications

		$mailer = $di_container->get('swiftmail.mailer');

		$users = $di_container->get('couch_model.user')
			->find_by_notification_setting('ticket-create.email');

		if ( ! count($users))
			return; // No users want emails about this

		// Use a view to generate the email
		$view = Kostache::factory('email/notification/ticket/create')
			->set('ticket', $ticket);

		$message = Swift_Message::newInstance()
			->setSubject($view->subject())
			->setFrom($view->from())
			->setBody($view->render());

		// Gather all the email addresses
		$emails = array();
		foreach ($users as $user)
		{
			$emails[] = $user->path('github.email');
		}
		// Add them using BCC for privacy
		$message->setBcc($emails);

		$mailer->send($message);
	}
}