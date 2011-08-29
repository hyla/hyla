<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Hyla_Install extends Minion_Task {

	public function execute( array $config)
	{
		Minion_CLI::write('Generating config/init.php'.PHP_EOL);
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

		Minion_CLI::write('Generating .htaccess'.PHP_EOL);
		$base_url = $view->base_url;

		$view = Kostache::factory('hyla/installer/htaccess')
			->set('base_url', $base_url);

		file_put_contents($view->save_path(), $view->render());
	}
}