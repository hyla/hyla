<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Workers_Notifier extends Minion_Task {

	public function execute(array $config)
	{
		$config = Kohana::$config->load('rabbitmq');
		$credentials = $config->servers['local'];
		$connection = new AMQPConnection($credentials);
		$connection->connect();

		$exchange = new AMQPExchange($connection);
		$exchange->declare('events', AMQP_EX_TYPE_TOPIC);

		$queue = new AMQPQueue($connection);
		$queue->declare('notifications', AMQP_EXCLUSIVE);
		// Bind to any model event
		$queue->bind('events', 'model.#');

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
		$handler = '_handle_'.str_replace('.', '.', $message['routing_key']);
		if (method_exists($this, $handler))
		{
			call_user_func(array($this, $handler), $message['msg']);
		}

	}

	protected function _handle_model_project_create($project_id)
	{
		// @TODO: Send an email to anyone that opted in
	}
}