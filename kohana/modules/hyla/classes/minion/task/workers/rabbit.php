<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Workers_Rabbit extends Minion_task {

	public function execute(array $config)
	{
		$config = Kohana::$config->load('rabbitmq');
		$credentials = $config->servers['local'];
		$connection = new AMQPConnection($credentials);
		$connection->connect();

		$exchange = new AMQPExchange($connection);
		$exchange->declare('logs', AMQP_EX_TYPE_FANOUT);

		$queue = new AMQPQueue($connection);
		$queue->declare('', AMQP_EXCLUSIVE);
		$queue->bind('logs', '');

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

	protected function _handle_message(Array $message)
	{
		Minion_CLI::write($message['msg']);
	}
}