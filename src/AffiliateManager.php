<?php namespace Cerbero\Affiliate;

use Illuminate\Support\Manager;

/**
 * Manager of the affiliations.
 *
 * @author	Andrea Marco Sartori
 */
class AffiliateManager extends Manager
{

	/**
	 * Retrieve the default driver name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function getDefaultDriver()
	{
		throw new \InvalidArgumentException("No affiliation has been specified.");
	}

	/**
	 * Retrieve the instance of an affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$affiliation
	 * @return	Cerbero\Affiliate\Affiliations\AffiliationInterface
	 */
	public function of($affiliation)
	{
		return $this->driver($affiliation);
	}

	/**
	 * Create an instance of the TradeDoubler affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Cerbero\Affiliate\Affiliations\AffiliateInterface
	 */
	protected function createTradeDoublerDriver()
	{
		return $this->app->make('cerbero.affiliate.affiliations.tradedoubler');
	}

	/**
	 * Create an instance of the Zanox affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Cerbero\Affiliate\Affiliations\AffiliateInterface
	 */
	protected function createZanoxDriver()
	{
		return $this->app->make('cerbero.affiliate.affiliations.zanox');
	}

	/**
	 * Create an instance of the TradeTracker affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Cerbero\Affiliate\Affiliations\AffiliateInterface
	 */
	protected function createTradeTrackerDriver()
	{
		return $this->app->make('cerbero.affiliate.affiliations.tradetracker');
	}

	/**
	 * Create an instance of the ClickPoint affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Cerbero\Affiliate\Affiliations\AffiliateInterface
	 */
	protected function createClickPointDriver()
	{
		return $this->app->make('cerbero.affiliate.affiliations.clickpoint');
	}

}