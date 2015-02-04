<?php namespace Cerbero\Affiliate\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * @see \Cerbero\Affiliate\Affiliations\Zanox
 */
class Zanox extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'cerbero.affiliate.affiliations.zanox'; }

}