<?php namespace Cerbero\Affiliate\Affiliations;

use Cerbero\Affiliate\Collectors\CollectorInterface;
use Zanox\Api\Adapter\Methods20110301Interface as Client;
use Cerbero\Date;

/**
 * Zanox affiliation.
 *
 * @author	Andrea Marco Sartori
 */
class Zanox extends AbstractAffiliation
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Zanox\Api\Adapter\Methods20110301Interface	$client	Zanox client.
	 */
	protected $client;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Affiliate\Collectors\CollectorInterface		$collector
	 * @param	Zanox\Api\Adapter\Methods20110301Interface			$client
	 * @return	void
	 */
	public function __construct(CollectorInterface $collector, Client $client)
	{
		parent::__construct($collector);

		$this->client = $client;
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

		extract($config);

		$this->client->setConnectId($connectId);

		$this->client->setSecretKey($secretKey);
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
	public function leadsInDates($start, $end, $data = [])
	{
		$results = array();

		extract($this->mergeDefaultData($data));

		$dates = $this->getRangeOfDates($start, $end);

		foreach ($dates as $date)
		{
			$report = $this->client->getLeads($date, $dateType, $programId, $adspaceId, $reviewState, $page, $items);

			$leads = object_get($report, 'leadItems.leadItem', []);

			$results = array_merge($results, $leads);
		}

		return $this->getCollectionOfResults($results);
	}

	/**
	 * Merge given data with default values.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	array
	 */
	private function mergeDefaultData(array $data)
	{
		$default = [
			'dateType'    => null,
			'programId'   => null,
			'adspaceId'   => null,
			'reviewState' => null,
			'page'        => 0,
			'items'       => 50
		];

		return array_merge($default, $data);
	}

	/**
	 * Retrieve a range of formatted dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$start
	 * @param	string|DateTime	$end
	 * @return	array
	 */
	private function getRangeOfDates($start, $end)
	{
		$range = Date::range($start, $end);

		return (array) Date::format($range, 'Y-m-d');
	}

}