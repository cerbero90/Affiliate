<?php

namespace spec\Cerbero\Affiliate\Affiliations;

use Cerbero\Affiliate\Parsers\ParserFactoryInterface;
use Cerbero\Affiliate\Parsers\ParserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClickPointSpec extends ObjectBehavior
{
	function let(ParserFactoryInterface $factory)
	{
		$this->beConstructedWith($factory);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Affiliations\ClickPoint');
    }

    /**
     * @testdox	It returns its name.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_its_name()
    {
    	$this->name()->shouldReturn('ClickPoint');
    }

    /**
     * @testdox	It sets and gets its configuration.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sets_and_gets_its_configuration()
    {
    	$this->setConfig(['foo']);

    	$this->getConfig()->shouldReturn(['foo']);
    }

    /**
     * @testdox	It builds the URL to call to get the leads done in a range of dates.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_builds_the_URL_to_call_to_get_the_leads_done_in_a_range_of_dates($factory, ParserInterface $parser)
    {
    	$this->setConfig(['id' => 123, 'code' => 22]);

    	$items = [ ['foo' => 'bar'] ];

    	$parser->parse()->shouldBeCalled()->willReturn($items);

    	$url = 'https://feed.clickpoint.com/network-feed?id=123&code=22&fromdate=2014-12-01&todate=2015-01-01';

    	$factory->createByInput($url)->shouldBeCalled()->willReturn($parser);

    	$collection = $this->leadsInDates('2014-12-01', '2015-01-01');

        $collection->shouldHaveType('Illuminate\Support\Collection');

        $collection->all()->shouldReturn($items);
    }

    /**
     * @testdox    It can customize the report of the leads done in a range of dates.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_can_customize_the_report_of_the_leads_done_in_a_range_of_dates($factory, ParserInterface $parser)
    {
    	$this->setConfig(['id' => 123, 'code' => 22]);

        $items = [ ['foo' => 'bar'] ];

        $parser->parse()->shouldBeCalled()->willReturn($items);

        $url = 'https://feed.clickpoint.com/network-feed?id=123&code=22&fromdate=2014-12-01&todate=2015-01-01&advertiser=foo';

        $factory->createByInput($url)->shouldBeCalled()->willReturn($parser);

        $collection = $this->leadsInDates('2014-12-01', '2015-01-01', ['advertiser' => 'foo']);

        $collection->shouldHaveType('Illuminate\Support\Collection');

        $collection->all()->shouldReturn($items);
    }
}
