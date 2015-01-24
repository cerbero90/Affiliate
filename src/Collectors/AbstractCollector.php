<?php namespace Cerbero\Affiliate\Collectors;

use Illuminate\Support\Collection;

/**
 * Abstract implementation of a collector.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractCollector implements CollectorInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Support\Collection	$collection	The collection.
	 */
	protected $collection;

	/**
	 * Collect the given data.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$data
	 * @return	void
	 */
	public function collect(array $data)
	{
		$boxed = array_map([$this, 'box'], $data);

		$this->collection = new Collection($boxed);
	}

	/**
	 * Retrieve the collection.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Support\Collection
	 */
	public function getCollection()
	{
		return $this->collection;
	}

	/**
	 * Box data before inserting it into the collection.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array|Object	$data
	 * @return	mixed
	 */
	abstract protected function box($data);

}