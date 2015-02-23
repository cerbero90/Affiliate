<?php namespace Cerbero\Affiliate\Clients;

use \SoapClient;

/**
 * Factory to create a SOAP client.
 *
 * @author	Andrea Marco Sartori
 */
class SoapClientFactory {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$location	Location of the web service to call.
	 */
	protected $location;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$headers	Headers of the calling.
	 */
	protected $headers;

	/**
	 * Set the location of the web service to call.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$location
	 * @return	void
	 */
	public function setLocation($location)
	{
		$this->location = $location;
	}

	/**
	 * Retrieve the location of the web service to call.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * Set the headers of the calling.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$headers
	 * @return	void
	 */
	public function setHeaders(array $headers)
	{
		$this->headers = $headers;
	}

	/**
	 * Retrieve the headers of the calling.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * Create the SOAP client.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	\SoapClient
	 */
	public function make()
	{
		return new SoapClient($this->location, $this->headers);
	}

}