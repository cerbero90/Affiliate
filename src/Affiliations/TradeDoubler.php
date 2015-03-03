<?php namespace Cerbero\Affiliate\Affiliations;

use Cerbero\Date;

/**
 * TradeDoubler affiliation.
 *
 * @author	Andrea Marco Sartori
 */
class TradeDoubler extends AbstractXmlUrlAffiliation
{

	const LEADS = 4;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$baseUrl	Base URL to call APIs.
	 */
	protected $baseUrl = 'https://publisher.tradedoubler.com/pan/aReport3Key.action';

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$queries	Default queries to append to every call.
	 */
	protected $queries = ['format' => 'XML'];

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$child	Child element of XML to start from.
	 */
	protected $child = 'row';

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
			'reportName' => 'aAffiliateEventBreakdownReport',
			'startDate'  => Date::format($start, 'd/m/y'),
			'endDate'    => Date::format($end, 'd/m/y'),
			'event_id'   => static::LEADS,

		], $data);

		return $this->getResultsByOptions($options);
	}

}