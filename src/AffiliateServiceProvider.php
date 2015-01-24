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
	 * @author	Andrea Marco Sartori
	 * @var		array	$affiliations	List of supported affiliations.
	 */
	protected $affiliations = ['TradeDoubler'];

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

		$this->registerCollector();

		foreach ($this->affiliations as $affiliation)
		{
			$this->registerAffiliation($affiliation);
		}

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
	 * Register the given affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$affiliation
	 * @return	void
	 */
	private function registerAffiliation($name)
	{
		$lower = strtolower($name);

		$this->app->bindShared("cerbero.affiliate.affiliations.{$lower}", function($app) use($name)
		{
			$affiliation = $app->make("Cerbero\Affiliate\Affiliations\\{$name}");

			$config = $app['config']["affiliate::{$name}"];

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
		);
	}

}
