<?php

namespace spec\Cerbero\Affiliate\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prewk\XmlStringStreamer;

class XmlStringStreamerParserSpec extends ObjectBehavior
{
	function let(XmlStringStreamer $streamer)
	{
		$this->beConstructedWith($streamer);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Parsers\XmlStringStreamerParser');
		$this->shouldHaveType('Cerbero\Affiliate\Parsers\ParserInterface');
    }

    /**
     * @testdox	It retrieves an array with parsed XML elements.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_an_array_with_parsed_XML_elements($streamer)
    {
    	$node = <<<XML
<row>
	<foo>1</foo>
	<bar>2014-12-05</bar>
	<baz>0.22</baz>
</row>
XML;
		$streamer->getNode()->will(function() use(&$node)
    	{
    		$tmp = $node;
    		$node = false;
    		return $tmp;
    	});

    	$this->parse()[0]->shouldbeAnInstanceOf('SimpleXMLElement');
    }
}
