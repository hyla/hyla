<?php defined('SYSPATH') or die('No direct script access.');

class Subscriber_Project_Notifications implements Interface_Subscriber {

	public function get_listeners()
	{
		return array(
			'hyla:worker.notifier:model.project.create' => array($this, 'send_project_create_email'),
		);
	}

	public function send_project_create_email(Interface_Event $event)
	{
		// The id of the project
		$id = $event->get_subject();
		$di_container = Arr::get($event->get_arguments(), 'di_container');

		$project = $di_container->get('couch_model.project')
			->find($id);

		if ( ! $project->loaded())
			return; // Project must have been deleted before we could send notifications

		$mailer = $di_container->get('swiftmail.mailer');

		$users = $di_container->get('couch_model.user')
			->find_by_notification_setting('project-create.email');

		if ( ! count($users))
			return; // No users want emails about this

		// Use a view to generate the email
		$view = Kostache::factory('email/notification/project/create')
			->set('project', $project);

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