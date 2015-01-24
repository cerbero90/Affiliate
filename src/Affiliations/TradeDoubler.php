<?php namespace Cerbero\Affiliate\Affiliations;

use Cerbero\Affiliate\Collectors\CollectorInterface;
use Cerbero\Affiliate\Parsers\ParserFactoryInterface;

/**
 * TradeDoubler affiliation.
 *
 * @author	Andrea Marco Sartori
 */
class TradeDoubler extends AbstractAffiliation
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$baseUrl	Base URL to call APIs.
	 */
	protected $baseUrl = 'https://publisher.tradedoubler.com/pan/aReport3Key.action';

	const LEADS = 4;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Affiliate\Parsers\ParserFactoryInterface	$parser
	 * @param	Cerbero\Affiliate\Collectors\CollectorInterface		$collector
	 * @return	void
	 */
	public function __construct(ParserFactoryInterface $parser, CollectorInterface $collector)
	{
		parent::__construct($parser, $collector);

		$this->parser->setChild('row');
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
		$default = [
			'reportName' => 'aAffiliateEventBreakdownReport',
			'startDate'  => $this->formatDate($start, 'd/m/y'),
			'endDate'    => $this->formatDate($end, 'd/m/y'),
			'event_id'   => self::LEADS,
		];

		$url = $this->buildUrl($default, $data);

		return $this->getResultsByUrl($url);
	}

	/**
	 * Build the URL to call.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$default
	 * @param	array	$data
	 * @return	string
	 */
	protected function buildUrl($default, $data = [])
	{
		$merged = array_merge($default, $this->appendData(), $data);

		$url = $this->baseUrl . '?' . http_build_query($merged, '', '&');

		// remove [n] added by http_build_query when it deals with arrays
		return preg_replace('/%5B\d+%5D/', '', $url);
	}

	/**
	 * Retrieve mandatory data to append.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	private function appendData()
	{
		$config = $this->getConfig();

		return $config + ['format' => 'XML'];
	}

}