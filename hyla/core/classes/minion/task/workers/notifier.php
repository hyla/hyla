<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Workers_Notifier extends Abstract_Minion_Task {

	public function execute(array $config)
	{
		$queue = KRabbit::factory()->queue('notifications');

		while(TRUE)
		{
			$message = (array) $queue->get();
			if (Arr::get($message, 'count') !== -1)
			{
				$this->_handle_message($message);
			}

			sleep(5);
		}

		$connection->disconnect();
	}

	protected function _handle_message(array $message)
	{
		$handler = '_handle_'.str_replace('.', '_', $message['routing_key']);
		if (method_exists($this, $handler))
		{
			call_user_func(array($this, $handler), $message['msg']);
		}

	}

	protected function _handle_model_project_create($project_id)
	{
		$project = $this->di_container->get('couch_model.project')
			->find($project_id);

		if ( ! $project->loaded())
			return; // Project must have been deleted before we could send notifications

		$mailer = $this->di_container->get('swiftmail.mailer');

		$users = $this->di_container->get('couch_model.user')
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