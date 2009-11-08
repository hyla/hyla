<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * The assets class handles loading view dependencies and simple assets.
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

class Yuriko_Assets {

	// asset 'groups' defined in the assets config files
	static protected $assets = array();

	static protected $scripts = array();
	static protected $stylesheets = array();
	static protected $loaded_dependencies = FALSE;

	/**
	 * Adds an asset group to the list of files to include
	 *
	 * @param String $key - config key of the asset group
	 */
	public static function add_asset($key)
	{
		self::$assets[$key] = Kohana::config('assets.'.$key);
	}

	/**
	 * Custom sorting method for assets based on 'weight' key
	 */
	public static function sort_assets($a, $b)
	{
        if ($a['weight'] == $b['weight']) {
            return 0;
        }
        return ($a['weight'] > $b['weight']) ? +1 : -1;
	}

	/**
	 * Renders all the proper assets depending on the views currently used
	 */
	public static function render()
	{
		// load dependencies
		if ( ! self::$loaded_dependencies)
		{
			self::load_dependencies();
		}
		// sort the assets
		usort(self::$assets, array('assets', 'sort_assets'));
		foreach (self::$assets as $asset)
		{
			// get array of files
			$files = array();
			if (isset($asset['file']))
			{
				$files[] = $asset['file'];
			}
			if (isset($asset['files']))
			{
				$files = array_merge($files, $asset['files']);
			}
			// output files

			foreach ($files as $file)
			{
				if (isset($asset['wrapper']))
				{
					echo $asset['wrapper'][0]."\n";
				}
				if ($file[1] === 'css')
				{
					echo html::style($file[0])."\n";
				}
				elseif ($file[1] === 'js')
				{
					echo html::script($file[0])."\n";
				}
				if (isset($asset['wrapper']))
				{
					echo $asset['wrapper'][1]."\n";
				}
			}
		}

	}

	/**
	 * Calculates all the dependencies based on which views were loaded
	 * for this request. Only runs once per request (should be done at the end)
	 * Called automatically by assets::all()
	 *
	 * @param Bool $force - will reload dependencies if TRUE
	 */
	public static function load_dependencies($force = FALSE)
	{
		if (!self::$loaded_dependencies OR $force)
		{
			// the Views that where used
			$views = (array)View::$loaded;
			// the assets that where defined
			$assets = (array)Kohana::config('assets');
			foreach ($assets as $key => $asset)
			{
				$testing_views = $views;
				$rules = $asset['rules'];
				// @TODO: cache stuff

				// check exclude rules first
				if (isset($rules['exclude_views']))
				{
					// unset any views that are excluded so we don't them
					$testing_views = array_diff($testing_views, $rules['exclude_views']);
				}
				if (isset($rules['exclude_regex']))
				{
					// @TODO: implement
				}
				if (isset($rules['exclude_directories']))
				{
					// unset any views that are in these directories
					$to_unset = array();
					foreach ($testing_views as $v)
					{
						if (self::is_in_directories(
								$rules['exclude_directories'], (array)$v))
						{
							$to_unset[] = $v;
						}
					}
					$testing_views = array_diff($testing_views, $to_unset);
				}

				// start testing inclusion rules (only need one match)
				if (isset($rules['views']))
				{
					$diff = array_diff($testing_views, $rules['views']);
					// if $diff is smaller, we had at least one match
					if (count($diff) < count($testing_views))
					{
						self::add_asset($key);
						// skip to next asset
						continue;
					}
				}

				if (isset($rules['directories']))
				{
					if (self::is_in_directories(
								$rules['directories'], $testing_views))
					{
						self::add_asset($key);
						// skip to next asset
						continue;
					}
				}

				// check regex last for performance reasons
				if (isset($rules['regex']))
				{
					// @TODO: implement
				}
			}
			self::$loaded_dependencies = TRUE;
		}
	}

	/**
	 *
	 * @param array $directories
	 * @param array $views - the array of view paths to test
	 * @return Bool
	 */
	public static function is_in_directories(array $directories, array $views)
	{
		$match = FALSE;

		foreach ($directories as $dir)
		{
			foreach ($views as $view)
			{
				// check if $dir is in the path of $view
				if (strpos(dirname($view), $dir) !== FALSE)
				{
					$match = TRUE;
				}
			}
		}
		return $match;
	}

	/**
	 *
	 * @param String $regex - the regex to test all the views against
	 * @param array $views - the array of view paths to test
	 * @return Bool
	 */
	public static function matches_regex(array $regexes, array $views)
	{
		// @TODO: implement
		return FALSE;
	}
} // End Assets