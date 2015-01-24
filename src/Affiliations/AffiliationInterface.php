<?php namespace Cerbero\Affiliate\Affiliations;

/**
 * Interface for affiliations.
 *
 * @author	Andrea Marco Sartori
 */
interface AffiliationInterface
{

	/**
	 * Retrieve the name of the affiliation.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function name();

	/**
	 * Set the base URL to call the APIs.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$url
	 * @return	void
	 */
	public function setBaseUrl($url);

	/**
	 * Retrieve the base URL to call the APIs.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function getBaseUrl();

	/**
	 * Set the configuration.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$config
	 * @return	void
	 */
	public function setConfig(array $config);

	/**
	 * Retrieve the configuration.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	public function getConfig();

	/**
	 * Retrieve the leads achieved in a range of dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$start
	 * @param	string	$end
	 * @param	array	$data
	 * @return	Illuminate\Support\Collection
	 */
	public function leadsInDates($start, $end, $data = []);

}