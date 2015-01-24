<?php namespace Cerbero\Affiliate\Affiliations;

use Illuminate\Support\Facades\Config;
use Cerbero\Affiliate\Parsers\ParserFactoryInterface;
use Cerbero\Affiliate\Collectors\CollectorInterface;

/**
 * Abstract implementation of an affiliation.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractAffiliation implements AffiliationInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Affiliate\Parsers\ParserFactoryInterface	$parser	Parser factory.
	 */
	protected $parser;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Affiliate\Collectors\CollectorInterface	$collector	Results collector.
	 */
	protected $collector;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$baseUrl	Base URL to call the APIs.
	 */
	protected $baseUrl;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$config	Configuration.
	 */
	protected $config;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Affiliate\Parsers\ParserFactoryInterface	$parser
	 * @param	Cerbero\Affiliate\Collectors\CollectorInterface		$collector
	 * @return	void
	 */
	public function __construct(ParserFactoryInterface $parser, CollectorInterface $collector)
	{
		$this->parser = $parser;

		$this->collector = $collector;
	}

	/**
	 * Retrieve the name of the affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function name()
	{
		$segments = explode('\\', get_called_class());

		return end($segments);
	}

	/**
	 * Set the base URL to call the APIs.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$url
	 * @return	void
	 */
	public function setBaseUrl($url)
	{
		$this->baseUrl = $url;
	}

	/**
	 * Retrieve the base URL to call the APIs.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function getBaseUrl()
	{
		return $this->baseUrl;
	}

	/**
	 * Set the configuration.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$config
	 * @return	void
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;
	}

	/**
	 * Retrieve the configuration.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * Retrieve the leads achieved in a range of dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$start
	 * @param	string	$end
	 * @param	array	$data
	 * @return	Illuminate\Support\Collection
	 */
	abstract public function leadsInDates($start, $end, $data = []);

	/**
	 * Retrieve the results obtained by calling a URL.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$url
	 * @return	Illuminate\Support\Collection
	 */
	protected function getResultsByUrl($url)
	{
		$items = $this->parser->createByInput($url)->parse();

		$this->collector->collect($items);

		return $this->collector->getCollection();
	}

	/**
	 * Check and format dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$date
	 * @return	string
	 */
	protected function formatDate($date, $format)
	{
		if($time = strtotime($date))
		{
			return date($format, $time);
		}

		throw new \InvalidArgumentException("The provided value is not a valid date: {$date}");
	}

}