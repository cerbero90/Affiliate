<?php

namespace spec\Cerbero\Affiliate\Affiliations;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cerbero\Affiliate\Parsers\ParserFactoryInterface;
use Cerbero\Affiliate\Parsers\ParserInterface;
use DateTime;

class TradeDoublerSpec extends ObjectBehavior
{
	function let(ParserFactoryInterface $factory)
	{
		$this->beConstructedWith($factory);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Affiliations\TradeDoubler');
        $this->shouldHaveType('Cerbero\Affiliate\Affiliations\AbstractAffiliation');
        $this->shouldHaveType('Cerbero\Affiliate\Affiliations\AffiliationInterface');
    }

    /**
     * @testdox	It retrieves its name.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_its_name()
    {
    	$this->name()->shouldReturn('TradeDoubler');
    }

    /**
     * @testdox	It sets and retrieves the configuration.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sets_and_retrieves_the_configuration()
    {
    	$config = ['key' => 123];

    	$this->setConfig($config);

    	$this->getConfig()->shouldReturn($config);
    }

    /**
     * @testdox	It builds the URL to call to get the leads done in a range of dates.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_builds_the_URL_to_call_to_get_the_leads_done_in_a_range_of_dates($factory, ParserInterface $parser)
    {
    	$this->setConfig(['key' => 123, 'affiliateId' => 22]);

    	$items = [ ['foo' => 'bar'] ];

    	$parser->parse()->shouldBeCalled()->willReturn($items);

    	$url = 'https://publisher.tradedoubler.com/pan/aReport3Key.action?format=XML&key=123&affiliateId=22&reportName=aAffiliateEventBreakdownReport&startDate=01%2F12%2F14&endDate=17%2F01%2F15&event_id=4';

    	$factory->createByInput($url)->shouldBeCalled()->willReturn($parser);

    	$collection = $this->leadsInDates('2014-12-01', '2015-01-17');

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
        $this->setConfig(['key' => 123, 'affiliateId' => 22]);

        $items = [ ['foo' => 'bar'] ];

        $parser->parse()->shouldBeCalled()->willReturn($items);

        $url = 'https://publisher.tradedoubler.com/pan/aReport3Key.action?format=XML&key=123&affiliateId=22&reportName=aAffiliateEventBreakdownReport&startDate=01%2F12%2F14&endDate=17%2F01%2F15&event_id=4&columns=programId&columns=timeOfEvent';

        $factory->createByInput($url)->shouldBeCalled()->willReturn($parser);

        $collection = $this->leadsInDates('2014-12-01', '2015-01-17', ['columns' => ['programId', 'timeOfEvent'] ]);

        $collection->shouldHaveType('Illuminate\Support\Collection');

        $collection->all()->shouldReturn($items);
    }

    /**
     * @testdox    It throws an exception if provided dates are not valid.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_throws_an_exception_if_provided_dates_are_not_valid()
    {
        $valid = '01/13/2000';

        $invalid = '13/01/2000';

        $this->shouldThrow('\InvalidArgumentException')->duringLeadsInDates($valid, $invalid);

        $this->shouldThrow('\InvalidArgumentException')->duringLeadsInDates($invalid, $valid);

        $this->shouldThrow('\InvalidArgumentException')->duringLeadsInDates($invalid, $invalid);
    }
}
