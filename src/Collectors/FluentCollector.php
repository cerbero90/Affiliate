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

		$attributes = $this->getAttributesByData($data);

		return new Fluent($attributes);
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
		$message = 'The collector should collect arrays or objects only.';

		if( ! is_array($data) && ! is_object($data))
		{
			throw new \InvalidArgumentException($message);
		}
	}

	/**
	 * Retrieve attributes by manipulating data.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$data
	 * @return	array
	 */
	private function getAttributesByData($data)
	{
		$encoded = json_encode($data);

		return json_decode($encoded, true);
	}

}