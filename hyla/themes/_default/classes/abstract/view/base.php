<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains methods useful to all views in an application.
 *
 * @package    Hyla
 * @category   Kostache
 * @author     Hyla
 */
abstract class Abstract_View_Base extends Kostache {

	public function logo_url()
	{
		return Media::url('images/hyla.png');
	}

	public function home_url()
	{
		return Route::url('hyla/home');
	}

	/**
	 * Assets object to add css/js groups to
	 */
	protected $_assets;

	/**
	 * Sets the Assets object in the view
	 * Extend this method in Views to add Asset groups.
	 *
	 *     public function assets($assets)
	 *     {
	 *         $assets->group('default-template');
	 *         return parent::assets($assets);
	 *     }
	 *
	 * @param  Object the Assets object
	 * @return this
	 */
	public function assets($assets)
	{
		$this->_assets = $assets;

		return $this;
	}
}