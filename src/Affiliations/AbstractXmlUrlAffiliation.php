<?php namespace Cerbero\Affiliate\Affiliations;

use Cerbero\Affiliate\Parsers\ParserFactoryInterface;

/**
 * Abstract implementation of an affiliation that calls an URL returning XML.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractXmlUrlAffiliation extends AbstractUrlAffiliation {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$child	Child elements of XML to grab.
	 */
	protected $child = '';

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Affiliate\Parsers\ParserFactoryInterface	$parser	Parser factory.
	 */
	protected $parser;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Affiliate\Parsers\ParserFactoryInterface	$parser
	 * @return	void
	 */
	public function __construct(ParserFactoryInterface $parser)
	{
		$this->parser = $parser;

		$this->parser->setChild($this->child);
	}

	/**
	 * Retrieve a collection of results.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$options
	 * @return	Illuminate\Support\Collection
	 */
	protected function getResultsByOptions(array $options)
	{
		$url = $this->buildUrl($options);

		$results = $this->parser->createByInput($url)->parse();

		return $this->getCollectionOfResults($results);
	}

}