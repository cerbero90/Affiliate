<?php namespace Cerbero\Affiliate\Facades\Manager;

use \Illuminate\Support\Facades\Facade;

/**
 * @see \Cerbero\Affiliate\AffiliateManager
 */
class Affiliate extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'cerbero.affiliate.manager';
	}

}