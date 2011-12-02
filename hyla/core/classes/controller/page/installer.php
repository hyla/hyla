<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page_Installer extends Abstract_Controller_Hyla_Page {

	public function before()
	{
		$this->view = $this->_request_view();
	}

	public function action_home()
	{
		if ($this->valid_post())
		{
			$init = Kostache::factory('file/config/init')
				->set('values', $this->request->post());

			file_put_contents($init->filepath(), $init->render());

			$couchdb = Kostache::factory('file/config/couchdb')
				->set('values', $this->request->post('couchdb'));

			file_put_contents($couchdb->filepath(), $couchdb->render());

			$couchapprc = Kostache::factory('file/couchapp/couchapprc')
				->set('values', $this->request->post('couchdb'));

			file_put_contents($couchapprc->filepath(), $couchapprc->render());
		}
	}

}