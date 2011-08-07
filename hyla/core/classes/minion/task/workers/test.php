<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Workers_Test extends Minion_task {

	public function execute(array $config)
	{
		while (TRUE)
		{
			Minion_CLI::write('This is a test worker. It will run for ever.');
			sleep(10);
		}
	}
}