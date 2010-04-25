<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * This is where assets and asset dependencies are defined.
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2010 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */
return array
(
	
	'default' => array
	(
		'css' => array
		(
			'hyla/themes/default/media/css/reset.css' => array(),
			'hyla/themes/default/media/css/text.css' => array(),
			'hyla/themes/default/media/css/960.css' => array(),
			'hyla/themes/default/media/css/layout.css' => array(),
			'hyla/themes/default/media/css/nav.css' => array(),
			'hyla/themes/default/media/css/ui.css' => array(),
			'hyla/themes/default/media/css/ie6.css' => array
			(
				// adds IE 6 conditionals around the stylesheet
				'wrapper' => array('<!--[if IE 6]>', '<![endif]-->'),
			),
			'hyla/themes/default/media/css/ie.css' => array
			(
				// adds IE 6 conditionals around the stylesheet
				'wrapper' => array('<!--[if IE 7]>', '<![endif]-->'),
			),
		),
		'js' => array
		(
			'hyla/themes/default/media/js/jquery-1.4.2.min.js' => array(),
			'hyla/themes/default/media/js/jquery-ui-1.8.custom.min.js' => array(),
		),
		'weight' => 50,
		// rules for when this asset should be included
		'pattern' => '^templates/default',
	),
);
