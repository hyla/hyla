<?php defined('SYSPATH') or die('No direct script access.');

class Model_OAuth2 extends Couch_Model implements Interface_Model_OAuth2 {

	public function __construct(Sag $sag)
	{
		parent::__construct($sag);

		$this->_config = Kohana::$config->load('oauth2');
	}
}