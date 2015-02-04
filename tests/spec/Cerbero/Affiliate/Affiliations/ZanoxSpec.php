<?php

namespace spec\Cerbero\Affiliate\Affiliations;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cerbero\Affiliate\Parsers\ParserFactoryInterface;
use Cerbero\Affiliate\Collectors\CollectorInterface;
use Zanox\Api\Adapter\Methods20110301Interface;
use StdClass;

class ZanoxSpec extends ObjectBehavior
{
	function let(CollectorInterface $collector, ZanoxClient $client)
	{
		$this->beConstructedWith($collector, $client);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Affiliations\Zanox');
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
    	$this->name()->shouldReturn('Zanox');
    }

    /**
     * @testdox	It sets and gets the configuration.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sets_and_gets_the_configuration($client)
    {
    	$config = ['connectId' => 10, 'secretKey' => '321'];

    	$client->setConnectId(10)->shouldBeCalled();

    	$client->setSecretKey('321')->shouldBeCalled();

    	$this->setConfig($config);

    	$this->getConfig()->shouldReturn($config);
    }

    /**
     * @testdox	It retrieves leads achieved in a range of dates.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_leads_achieved_in_a_range_of_dates($client, $collector)
    {
    	$client->getLeads('2000-01-01', null, null, null, null, 0, 50)->shouldBeCalled()->willReturn($this->lead('foo'));
    	$client->getLeads('2000-01-02', null, null, null, null, 0, 50)->shouldBeCalled()->willReturn($this->lead('bar'));
    	$client->getLeads('2000-01-03', null, null, null, null, 0, 50)->shouldBeCalled()->willReturn($this->lead('baz'));

    	$collector->collect(['foo', 'bar', 'baz'])->shouldBeCalled();

    	$collector->getCollection()->shouldBeCalled()->willReturn('collection');

    	$this->leadsInDates('2000-01-01', '2000-01-03')->shouldReturn('collection');
    }

    /**
     * Create a fake response with the given lead.
     *
     * @author	Andrea Marco Sartori
     * @param	string	$lead
     * @return	StdClass
     */
    private function lead($lead)
    {
    	$response = new StdClass;
    	$response->leadItems = new StdClass;
    	$response->leadItems->leadItem = [$lead];

    	return $response;
    }

    /**
     * @testdox	It allows custom parameters when retrieving achieved leads.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_allows_custom_parameters_when_retrieving_achieved_leads($client, $collector)
    {
    	$client->getLeads('2000-01-01', 'clickDate', null, 123, 'confirmed', 2, 50)->shouldBeCalled()->willReturn($this->lead('foo'));
    	$client->getLeads('2000-01-02', 'clickDate', null, 123, 'confirmed', 2, 50)->shouldBeCalled()->willReturn($this->lead('bar'));

    	$collector->collect(['foo', 'bar'])->shouldBeCalled();

    	$collector->getCollection()->shouldBeCalled()->willReturn('collection');

		$custom = [
			'dateType'    => 'clickDate',
			'adspaceId'   => 123,
			'reviewState' => 'confirmed',
			'page'        => 2
		];

    	$this->leadsInDates('2000-01-01', '2000-01-02', $custom)->shouldReturn('collection');
    }
}

interface ZanoxClient extends Methods20110301Interface {
	
	public function setConnectId($connectId);

	public function setSecretKey($secretKey);
}