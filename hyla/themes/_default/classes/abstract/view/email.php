<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains methods useful to pages
 *
 * @package    Hyla
 * @category   Kostache
 */
abstract class Abstract_View_Email extends Abstract_View_Layout {

	protected $_layout = 'layout/email';

	public $subject = 'Hyla Email';

	public function subject()
	{
		return $this->subject;
	}

	public function from()
	{
		// @TODO: add a config for this
		return 'dev@dev.vm';
	}
}
