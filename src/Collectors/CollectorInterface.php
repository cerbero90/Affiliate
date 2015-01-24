<?php namespace Cerbero\Affiliate\Collectors;

/**
 * Interface for collectors.
 *
 * @author	Andrea Marco Sartori
 */
interface CollectorInterface
{

	/**
	 * Collect the given data.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	void
	 */
	public function collect(array $data);

	/**
	 * Retrieve the collection.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Support\Collection
	 */
	public function getCollection();

}