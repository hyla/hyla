<?php defined('SYSPATH') or die('No direct script access.');

class Subscriber_Tracker_Navigation implements Interface_Subscriber {

	public function get_listeners()
	{
		return array(
			'hyla:project.sub-nav' => array($this, 'sub_navigation'),
		);
	}

	/**
	 * Adds tracker related items to the sub navigation of a project.
	 *
	 * @param  Interface_Event  $event the event object
	 * @return void
	 */
	public function sub_navigation(Interface_Event $event)
	{
		// The navigation object gets passed in from the event
		$navigation = $event->get_subject();
		// The project is passed as arguments in the event
		$project = Arr::get($event->get_arguments(), 'project');

		$navigation->add(array(
			'url'  => Route::url('tracker/home', array('slug' => $project->get('slug'))),
			'text' => 'Tracker',
		));
	}
}