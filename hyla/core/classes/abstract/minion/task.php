<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_Minion_Task extends Minion_Task {

	/**
	 * @var object the Dependency Container object
	 */
	public $di_container;

	/**
	 * @var object the event dispatcher for this task
	 */
	public $dispatcher;

	public function __construct()
	{
		$definitions = Dependency_Definition_List::factory()
			->from_array(Kohana::$config->load('dependencies')->as_array());
		$this->di_container = new Dependency_Container($definitions);

		$this->dispatcher = Event_Dispatcher::factory()
			->load_subscribers();
	}
}