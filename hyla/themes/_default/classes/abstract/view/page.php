<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains methods useful to pages
 *
 * @package    Hyla
 * @category   Kostache
 * @author     Synapse Studios
 */
abstract class Abstract_View_Page extends Abstract_View_Layout {

	// The Page Title
	public $title = NULL;

	public function title()
	{
		return $this->title;
	}

	public function assets($assets)
	{
		// All pages should have this asset group
		$assets->group('default-page');
		return parent::assets($assets);
	}

	public function assets_head()
	{
		if ( ! $this->_assets)
			return '';

		$assets = '';
		foreach ($this->_assets->get('head') as $asset)
		{
			$assets .= $asset."\n";
		}

		return $assets;
	}

	public function assets_body()
	{
		if ( ! $this->_assets)
			return '';

		$assets = '';
		foreach ($this->_assets->get('body') as $asset)
		{
			$assets .= $asset;
		}

		return $assets;
	}

	public function render($template = NULL, $view = NULL, $partials = NULL)
	{
		$content = parent::render($template, $view, $partials);

		return str_replace(array
		(
			'[[assets_head]]',
			'[[assets_body]]'
		), array
		(
			$this->assets_head(),
			$this->assets_body()
		), $content);
	}

	public function profiler()
	{
		return View::factory('profiler/stats');
	}
}
