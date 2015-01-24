<?php namespace Cerbero\Affiliate\Parsers;

use Prewk\XmlStringStreamer;

/**
 * Parser of XML responses.
 *
 * @author	Andrea Marco Sartori
 */
class XmlStringStreamerParser implements ParserInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Prewk\XmlStringStreamer	$streamer	XML string streamer.
	 */
	protected $streamer;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Prewk\XmlStringStreamer	$streamer
	 * @return	void
	 */
	public function __construct(XmlStringStreamer $streamer)
	{
		$this->streamer = $streamer;
	}

	/**
	 * Parse a response turning it into an array.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	public function parse()
	{
		$parsed = [];

		while ($node = $this->streamer->getNode())
		{
			$parsed[] = simplexml_load_string($node);
		}

		return $parsed;
	}

}