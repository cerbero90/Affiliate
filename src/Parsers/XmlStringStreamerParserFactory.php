<?php namespace Cerbero\Affiliate\Parsers;

use Prewk\XmlStringStreamer\Stream\Guzzle;
use Prewk\XmlStringStreamer\Parser\UniqueNode;
use Prewk\XmlStringStreamer\Parser\StringWalker;
use Prewk\XmlStringStreamer;
use GuzzleHttp\Stream\Stream;

/**
 * Parser factory.
 *
 * @author	Andrea Marco Sartori
 */
class XmlStringStreamerParserFactory extends AbstractParserFactory
{

	/**
	 * Create an instance of a parser depending on the given input.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$input
	 * @return	Cerbero\Affiliate\Parsers\ParserInterface
	 */
	public function createByInput($input)
	{
		if($this->isUrl($input)) return $this->createParserByUrl($input);

		if(is_resource($input)) $input = Stream::factory($input);

		if($input instanceof Stream) return $this->createParserByStream($input);

		throw new \InvalidArgumentException("The provided input in neither a URL, nor a stream.");
	}

	/**
	 * Check if the given input is a valid URL.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$input
	 * @return	boolean
	 */
	private function isUrl($input)
	{
		return filter_var($input, FILTER_VALIDATE_URL) !== false;
	}

	/**
	 * Create the parser by the given URL.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$url
	 * @return	Cerbero\Affiliate\Parsers\XmlStringStreamerParser
	 */
	private function createParserByUrl($url)
	{
		$guzzle = new Guzzle($url);

		return $this->createParserByGuzzle($guzzle);
	}

	/**
	 * Create a new XML string streamer by the given stream.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	GuzzleHttp\Stream\Stream	$stream
	 * @return	Cerbero\Affiliate\Parsers\ParserInterface
	 */
	private function createParserByStream(Stream $stream)
	{
		$guzzle = new Guzzle('');

		$guzzle->setGuzzleStream($stream);

		return $this->createParserByGuzzle($guzzle);
	}

	/**
	 * Build the parser by using a Guzzle stream.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Prewk\XmlStringStreamer\Stream\Guzzle	$guzzle
	 * @return	Cerbero\Affiliate\Parsers\ParserInterface
	 */
	private function createParserByGuzzle($guzzle)
	{
		$parser = $this->getBetterParser();

		$streamer = new XmlStringStreamer($parser, $guzzle);

		return new XmlStringStreamerParser($streamer);
	}

	/**
	 * Retrieve the better parser depending on the child is set.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	mixed
	 */
	private function getBetterParser()
	{
		if(isset($this->child))
		{
			return new UniqueNode(['uniqueNode' => $this->child]);
		}

		return new StringWalker;
	}

}