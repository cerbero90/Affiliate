<?php namespace Cerbero\Affiliate\Collectors;

use Illuminate\Support\Fluent;

/**
 * Collect data into Fluent objects collection.
 *
 * @author	Andrea Marco Sartori
 */
class FluentCollector extends AbstractCollector
{

	/**
	 * Box data before inserting it into the collection.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array|Object	$data
	 * @return	Illuminate\Support\Fluent
	 */
	protected function box($data)
	{
		$this->checkData($data);

		$filtered = array_filter((array) $data);

		return new Fluent($filtered);
	}

	/**
	 * Check the given data is valid.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$data
	 * @return	void
	 */
	private function checkData($data)
	{
		if( ! is_array($data) && ! is_object($data))
		{
			throw new \InvalidArgumentException("The collector should collect arrays or objects only.");
		}
	}

}