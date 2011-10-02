<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'krabbit' => array(
		'_settings' => array(
			'class'       => 'KRabbit',
			'constructor' => 'factory',
			'shared'      => TRUE,
		),
	),
	'couchdb' => array(
		'_settings' => array(
			'class'     => 'Sag',
			'arguments' => array('@couchdb.host@', '@couchdb.port@'),
		),
	),
	'couch_model' => array(
		'_settings' => array(
			'class'       => 'Couch_Model',
			'constructor' => 'factory',
		),
		'user' => array(
			'_settings' => array(
				'arguments' => array('user', '%couchdb%'),
			),
		),
		'project' => array(
			'_settings' => array(
				'arguments' => array('project', '%couchdb%'),
			),
		),
	),
	'swiftmail' => array(
		'_settings' => array(
			'path' => 'vendor/swiftmailer/lib/swift_required',
		),
		'transport' => array(
			'_settings' => array(
				'class'     => 'Swift_SendmailTransport',
			),
		),
		'mailer' => array(
			'_settings' => array(
				'class'     => 'Swift_Mailer',
				'arguments' => array('%swift.transport%'),
				'shared'    => TRUE,
			),
		),
	),
);