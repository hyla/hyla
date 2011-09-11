<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Projects_Tracker extends Abstract_Controller_Hyla_Page {

	public function action_list()
	{
		$this->view
			->bind('project', $project);

		$project = Couch_Model::factory('project', $this->couchdb)
			->find_by_slug($this->request->param('slug'));

		if ( ! $project->loaded())
			throw new HTTP_Exception_404;
	}

	public function action_new()
	{
		$this->view
			->bind('project', $project)
			->bind('ticket', $ticket)
			->bind('values', $values)
			->bind('errors', $errors);

		$project = Couch_Model::factory('project', $this->couchdb)
			->find_by_slug($this->request->param('slug'));

		if ( ! $project->loaded())
			throw new HTTP_Exception_404;

		if ($this->request->post())
		{
			$values = $this->request->post();

			try
			{
				$ticket = Couch_Model::factory('ticket', $this->couchdb);
				$ticket->values($values, array('title', 'description'));
				$ticket->set('project_id', $project->get('_id'));
				$ticket->set('created_by', $this->auth->get('_id'));
				$ticket->create();

				$this->request->redirect(Route::url('hyla-tracker', array(
					'slug' => $project->get('slug'),
				)));
			}
			catch (Validation_Exception $e)
			{
				$errors = $e->array->errors('validation');
			}
		}
	}

	public function action_view()
	{
		$this->view
			->bind('project', $project)
			->bind('ticket', $ticket);

		$project = Couch_Model::factory('project', $this->couchdb)
			->find_by_slug($this->request->param('slug'));

		$request = Request::factory(Route::get('hyla/api/tickets')->uri(array(
			'id' => $this->request->param('ticket'),
		)));
		$response = $this->oauth_client->execute($request);

		$ticket = Arr::get(json_decode($response->body(), TRUE), 'ticket');

		if ( ! $project->loaded() OR empty($ticket['_id']))
			throw new HTTP_Exception_404;
	}

	public function action_update()
	{
		$this->view
			->bind('project', $project)
			->bind('ticket', $ticket)
			->bind('values', $values)
			->bind('errors', $errors);

		$project = Couch_Model::factory('project', $this->couchdb)
			->find_by_slug($this->request->param('slug'));

		$request = Request::factory(Route::get('hyla/api/tickets')->uri(array(
			'id' => $this->request->param('ticket'),
		)));
		$response = $this->oauth_client->execute($request);

		$ticket = Arr::get(json_decode($response->body(), TRUE), 'ticket');

		if ( ! $project->loaded() OR empty($ticket['_id']))
			throw new HTTP_Exception_404;

		if ($this->request->post())
		{
			$comment = $this->request->post('comment');

			try
			{
				$ticket->add_comment($this->auth->get('_id'), $comment);
				$ticket->update();

				$this->request->redirect(Route::url('hyla-tracker', array(
					'action' => 'view',
					'slug'   => $project->get('slug'),
					'ticket' => $ticket->get('_id'),
				)));
			}
			catch (Validation_Exception $e)
			{
				$errors = $e->array->errors('validation');
			}
		}
	}

	public function action_delete()
	{
		$project = Couch_Model::factory('project', $this->couchdb)
			->find_by_slug($this->request->param('slug'));

		if ($this->request->post())
		{
			$request = Request::factory(Route::get('hyla/api/tickets')
			->uri(array(
				'id' => $this->request->param('ticket'),
			)))
			->method(Request::DELETE);
			$response = $this->oauth_client->execute($request);

			$this->request->redirect(Route::url('hyla-tracker', array(
					'slug' => $project->get('slug'),
				)));
		}

		throw new HTTP_Exception_404;
	}
}