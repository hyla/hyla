<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Hyla_Install extends Minion_Task {

	protected $_config = array(
		'skip-init'     => FALSE,
		'skip-htaccess' => FALSE,
	);

	public function execute( array $config)
	{
		if ($config['skip-init'] === FALSE)
		{
			$view = Kostache::factory('hyla/installer/config/init');
			foreach ($view->required_input() as $key => $info)
			{
				$response = Minion_CLI::read($info['line']);
				$response = Valid::not_empty($response)
					? $response
					: $info['default'];

				$view->set($key, $response);
			}

			file_put_contents($view->save_path(), $view->render());
		}

		if ($config['skip-htaccess'] === FALSE)
		{
			$base_url = ($config['skip-init'] === FALSE)
				? $view->base_url
				: Kohana::$base_url;

			$view = Kostache::factory('hyla/installer/htaccess')
				->set('base_url', $base_url);

			file_put_contents($view->save_path(), $view->render());
		}
	}
}