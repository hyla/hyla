<?php defined('SYSPATH') or die('No direct script access.');

class KRabbit {

	public static function factory()
	{
		return new KRabbit;
	}

	protected $_config;
	protected $_connections = array();
	protected $_exchanges   = array();
	protected $_queues      = array();

	protected function __construct()
	{
		$this->_config = Kohana::$config->load('rabbitmq');
	}

	public function connection($server)
	{
		// Create the connection to the RabbitMQ server if we haven't yet
		if ( ! isset($this->_connections[$server]))
		{
			$credentials = $this->_config->servers[$server];
			$connection = new AMQPConnection($credentials);
			$connection->connect();

			$this->_connections[$server] = $connection;
		}

		return $this->_connections[$server];
	}

	public function exchange($name)
	{
		// Create the exchange if we haven't yet
		if ( ! isset($this->_exchanges[$name]))
		{
			$info = $this->_config->exchanges[$name];

			$exchange = new AMQPExchange($this->connection($info['connection']));
			$exchange->declare($info['name'], $info['type'], $info['flags']);

			$this->_exchanges[$name] = $exchange;
		}

		return $this->_exchanges[$name];
	}

	public function queue($name)
	{
		// Create the queue if we haven't yet
		if ( ! isset($this->_queues[$name]))
		{
			$info = $this->_config->queues[$name];

			$queue = new AMQPQueue($this->connection($info['connection']));
			$queue->declare($info['name'], $info['flags']);

			// Bind to exchanges
			foreach ($info['bindings'] as $exchange => $routing_key)
			{
				// Make sure it is declared
				$this->exchange($exchange);
				// Bind to it
				$queue->bind($this->_config->exchanges[$exchange]['name'], $routing_key);
			}

			$this->_queues[$name] = $queue;
		}

		return $this->_queues[$name];
	}
}