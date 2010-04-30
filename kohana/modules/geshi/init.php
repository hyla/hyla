<?php defined('SYSPATH') or die('No direct script access.');

Class GeSHi_Loader {

	public static function auto_load($class)
	{
		if (strtolower($class) === 'geshi')
		{
			require Kohana::find_file('vendor', 'geshi');
			return TRUE;
		}
		return FALSE;
	}
}
/* Set autoloader for GeSHi */
spl_autoload_register(array('GeSHi_Loader', 'auto_load'));