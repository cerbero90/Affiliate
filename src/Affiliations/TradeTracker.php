<?php namespace Cerbero\Affiliate\Affiliations;

use Cerbero\Date;
use Illuminate\Support\Collection;
use Cerbero\Affiliate\Clients\SoapClientFactory;

/**
 * TradeTracker affiliation.
 *
 * @author	Andrea Marco Sartori
 */
class TradeTracker extends AbstractAffiliation {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$location	Location of web service to use.
	 */
	protected $location = 'http://ws.tradetracker.com/soap/affiliate?wsdl';
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Affiliate\Clients\SoapClientFactory		$client
	 * @return	void
	 */
	public function __construct(SoapClientFactory $client)
	{
		$this->setClient($client);
	}

	/**
	 * Set the client.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Affiliate\Clients\SoapClientFactory	$client
	 * @return	void
	 */
	protected function setClient(SoapClientFactory $client)
	{
		$client->setLocation($this->location);

		$client->setHeaders([
			'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP
		]);

		$this->client = $client->make();
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

		$this->client->authenticate($clientId, $passphrase);
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
		$options = array_merge(
		[
			'registrationDateFrom' => Date::format($start, 'Y-m-d'),
			'registrationDateTo'   => Date::format($end, 'Y-m-d'),
			'transactionType'      => 'lead',

		], $data);

		$results = $this->client->getConversionTransactions($this->config['siteId'], $options);

		return $this->getCollectionOfResults($results);
	}

}