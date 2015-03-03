<?php namespace Cerbero\Affiliate\Affiliations;

use Cerbero\Date;

/**
 * ClickPoint affiliation.
 *
 * @author	Andrea Marco Sartori
 */
class ClickPoint extends AbstractXmlUrlAffiliation {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$baseUrl	Base URL to call APIs.
	 */
	protected $baseUrl = 'https://feed.clickpoint.com/network-feed';

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$child	Child elements of XML to grab.
	 */
	protected $child = 'Transaction';

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
			'fromdate'  => Date::format($start, 'Y-m-d'),
			'todate'    => Date::format($end, 'Y-m-d'),

		], $data);

		return $this->getResultsByOptions($options);
	}

}