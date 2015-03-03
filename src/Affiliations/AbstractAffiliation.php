<?php namespace Cerbero\Affiliate\Affiliations;

use Illuminate\Support\Collection;

/**
 * Abstract implementation of an affiliation.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractAffiliation implements AffiliationInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$config	Configuration.
	 */
	protected $config;

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
	 * Retrieve a collection of results.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$results
	 * @return	Illuminate\Support\Collection
	 */
	protected function getCollectionOfResults(array $results)
	{
		return Collection::make($results);
	}

}