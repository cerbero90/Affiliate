<?php namespace Cerbero\Affiliate\Affiliations;

/**
 * Abstract implementation of an affiliation that calls an URL to grab data.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractUrlAffiliation extends AbstractAffiliation {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$baseUrl	The base of the URL to call.
	 */
	protected $baseUrl = '';

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$queries	Default queries to append to every call.
	 */
	protected $queries = [];

	/**
	 * Build the URL to call.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$options
	 * @return	string
	 */
	protected function buildUrl($options = [])
	{
		$merged = array_merge($this->queries, $this->getConfig(), $options);

		$url = $this->baseUrl . '?' . http_build_query($merged, '', '&');

		return $this->optimizeUrl($url);
	}

	/**
	 * Remove indexes added when dealing with arrays.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$url
	 * @return	string
	 */
	private function optimizeUrl($url)
	{
		return preg_replace('/%5B\d+%5D/', '', $url);
	}

}