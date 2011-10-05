<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Workers_Notifier extends Abstract_Minion_Task {

	public function execute(array $config)
	{
		$queue = KRabbit::factory()->queue('notifications');

		while(TRUE)
		{
			Minion_CLI::write('Waiting for notification queue items');
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
		$event = $message['routing_key'];
		$id = $message['msg'];
		$arguments = array(
			'di_container' => $this->di_container,
		);

		Minion_CLI::write($event.' :: '.$id);

		// Use the dispatcher to let interested code handle this event
		$this->dispatcher->trigger('hyla:worker.notifier:'.$event, new Event($id, $arguments));
	}
}