<?php namespace Cerbero\Affiliate\Parsers;

/**
 * Interface for parser factories.
 *
 * @author	Andrea Marco Sartori
 */
interface ParserFactoryInterface
{

	/**
	 * Set the child node to parse.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$child
	 * @return	$this
	 */
	public function setChild($child);

	/**
	 * Create an instance of a parser depending on the given input.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$input
	 * @return	Cerbero\Affiliate\Parsers\ParserInterface
	 */
	public function createByInput($input);

}