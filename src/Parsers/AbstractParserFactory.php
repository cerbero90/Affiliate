<?php namespace Cerbero\Affiliate\Parsers;

/**
 * Abstract implementation of a parser factory.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractParserFactory implements ParserFactoryInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$child	Child node to parse.
	 */
	protected $child;

	/**
	 * Set the child node to parse.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$child
	 * @return	$this
	 */
	public function setChild($child)
	{
		$this->child = $child;

		return $this;
	}

}