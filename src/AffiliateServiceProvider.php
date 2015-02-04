<?php namespace Cerbero\Affiliate;

use Illuminate\Support\ServiceProvider;

class AffiliateServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

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
		$this->registerCollector();

		$this->registerParserFactory();

		$this->registerTradeDoubler();

		$this->registerZanox();

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
	 * Register the collector.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerCollector()
	{
		$collector = 'Cerbero\Affiliate\Collectors\FluentCollector';

		$this->app->bind('Cerbero\Affiliate\Collectors\CollectorInterface', $collector);
	}

	/**
	 * Register TradeDoubler.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerTradeDoubler()
	{
		$this->app->bindShared("cerbero.affiliate.affiliations.tradedoubler", function($app)
		{
			$affiliation = $app->make("Cerbero\Affiliate\Affiliations\TradeDoubler");

			$config = $app['config']["affiliate::TradeDoubler"];

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
		$this->app->bindShared("cerbero.affiliate.affiliations.zanox", function($app)
		{
			$affiliation = new Affiliations\Zanox
			(
				$app['Cerbero\Affiliate\Collectors\CollectorInterface'],

				\Zanox\ApiClient::factory()
			);

			$config = $app['config']["affiliate::Zanox"];

			$affiliation->setConfig($config);

			return $affiliation;
		});
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
		);
	}

}
