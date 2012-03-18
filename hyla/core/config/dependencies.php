<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'krabbit' => array(
		'_settings' => array(
			'class'       => 'KRabbit',
			'constructor' => 'factory',
			'shared'      => TRUE,
		),
	),
	'model' => array(
		'user' => array(
			'_settings' => array(
				'class' => 'Model_User',
			),
		),
		'project' => array(
			'_settings' => array(
				'class' => 'Model_Project',
			),
		),
		'ticket' => array(
			'_settings' => array(
				'class' => 'Model_Ticket',
			),
		),
	),
	'swiftmail' => array(
		'_settings' => array(
			'path' => 'vendor/swiftmailer/lib/swift_required',
		),
		'transport' => array(
			'_settings' => array(
				'class'       => 'Swift_SmtpTransport',
				'constructor' => 'newInstance',
				'arguments'   => array('@email.smtp_host@', '@email.smtp_port@'),
				'methods'     => array(
					array('setUsername', array('@email.smtp_username@')),
					array('setPassword', array('@email.smtp_password@')),
				),
			),
		),
		'mailer' => array(
			'_settings' => array(
				'class'       => 'Swift_Mailer',
				'constructor' => 'newInstance',
				'arguments'   => array('%swiftmail.transport%'),
				'shared'      => TRUE,
			),
		),
	),
);