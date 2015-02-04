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