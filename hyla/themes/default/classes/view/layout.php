<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains methods useful to views that use layouts
 *
 * @package    Hyla
 * @category   Kostache
 * @author     Synapse Studios
 */
class View_Layout extends View_Base
{
	protected $_layout = 'layout/default';

	/**
	 * Renders the body template into the layout
	 */
	public function render($template = null, $view = null, $partials = null)
	{
		$this->_partial_paths += array
		(
			'body' => $this->_template_path
		);

		// Make the layout view the child class's template
		$this->_template_path = $this->_layout;

		return parent::render($template, $view, $partials);
	}
} // End View_Layout
