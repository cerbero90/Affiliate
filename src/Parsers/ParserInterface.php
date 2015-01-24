<?php namespace Cerbero\Affiliate\Parsers;

/**
 * Interface for parsers.
 *
 * @author	Andrea Marco Sartori
 */
interface ParserInterface
{

	/**
	 * Parse a response turning it into an array.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	public function parse();

}