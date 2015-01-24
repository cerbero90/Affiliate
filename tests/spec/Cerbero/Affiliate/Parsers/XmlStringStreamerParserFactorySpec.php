<?php

namespace spec\Cerbero\Affiliate\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp\Stream\Stream;

class XmlStringStreamerParserFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Parsers\XmlStringStreamerParserFactory');
    }

    /**
     * @testdox	It creates a parser when receives a URL as input.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_creates_a_parser_when_receives_a_URL_as_input()
    {
    	$this->createByInput('http://www.google.it')->shouldBeAnInstanceOf('Cerbero\Affiliate\Parsers\XmlStringStreamerParser');
    }

    /**
     * @testdox	It creates a parser when receives a stream.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_creates_a_parser_when_receives_a_stream()
    {
    	$stream = tmpfile();

    	$this->createByInput($stream)->shouldBeAnInstanceOf('Cerbero\Affiliate\Parsers\XmlStringStreamerParser');
    }

    /**
     * @testdox    It creates a parser when receives a Guzzle stream.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_creates_a_parser_when_receives_a_Guzzle_stream()
    {
        $guzzle = Stream::factory(tmpfile());

        $this->createByInput($guzzle)->shouldBeAnInstanceOf('Cerbero\Affiliate\Parsers\XmlStringStreamerParser');
    }

    /**
     * @testdox	It throws an exception when a type of input is not handled.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_throws_an_exception_when_a_type_of_input_is_not_handled()
    {
    	$this->shouldThrow('\InvalidArgumentException')->duringCreateByInput(null);
    }

    /**
     * @testdox	It returns itself after setting the child node.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_itself_after_setting_the_child_node()
    {
    	$this->setChild('foo')->shouldReturn($this);
    }
}
