<?php namespace Cerbero\Affiliate;

use Illuminate\Support\ServiceProvider;

class AffiliateServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cerbero/affiliate', null, __DIR__);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerParserFactory();

		$this->registerAffiliation('TradeDoubler');

		$this->registerZanox();

		$this->registerAffiliation('TradeTracker');

		$this->registerAffiliation('ClickPoint');

		$this->registerManager();
	}

	/**
	 * Register the parser factory.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerParserFactory()
	{
		$factory = 'Cerbero\Affiliate\Parsers\XmlStringStreamerParserFactory';

		$this->app->bind('Cerbero\Affiliate\Parsers\ParserFactoryInterface', $factory);
	}

	/**
	 * Register a given affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerAffiliation($name)
	{
		$alias = 'cerbero.affiliate.affiliations.' . strtolower($name);

		$this->app->bindShared($alias, function($app) use($name)
		{
			$affiliation = $app["Cerbero\Affiliate\Affiliations\\{$name}"];

			$config = $app['config']["affiliate::{$name}"];

			$affiliation->setConfig($config);

			return $affiliation;
		});
	}

	/**
	 * Register Zanox.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerZanox()
	{
		$this->app->bind('Zanox\Api\Adapter\Methods20110301Interface', function()
		{
			return \Zanox\ApiClient::factory();
		});

		$this->registerAffiliation('Zanox');
	}

	/**
	 * Register the manager of the affiliations.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerManager()
	{
		$this->app->bindShared('cerbero.affiliate.manager', function($app)
		{
			return new AffiliateManager($app);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'cerbero.affiliate.manager',
			'cerbero.affiliate.affiliations.tradedoubler',
			'cerbero.affiliate.affiliations.zanox',
			'cerbero.affiliate.affiliations.tradetracker',
			'cerbero.affiliate.affiliations.clickpoint',
		);
	}

}
