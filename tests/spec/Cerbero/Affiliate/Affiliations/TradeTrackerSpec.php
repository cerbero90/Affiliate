<?php

namespace spec\Cerbero\Affiliate\Affiliations;

use Cerbero\Affiliate\Clients\SoapClientFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TradeTrackerSpec extends ObjectBehavior
{
	function let(SoapClientFactory $client, SoapMethodsToCall $soap)
	{
		$this->beConstructedWith($client);

		$client->setLocation('http://ws.tradetracker.com/soap/affiliate?wsdl')->shouldBeCalled();

		$client->setHeaders(Argument::type('array'))->shouldBeCalled();

		$client->make()->willReturn($soap);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Affiliations\TradeTracker');
    }

    /**
     * @testdox	It sets the configuration.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sets_the_configuration($soap)
    {
    	$config = ['clientId' => 123, 'passphrase' => 'abc', 'siteId' => 111];

		$soap->authenticate(123, 'abc')->shouldBeCalled();

		$this->setConfig($config);

		$this->getConfig()->shouldReturn($config);
    }

    /**
     * @testdox	It retrieves its name.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_its_name()
    {
    	$this->name()->shouldReturn('TradeTracker');
    }

    /**
     * @testdox    It retrieves the leads achieved in a range of dates.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_retrieves_the_leads_achieved_in_a_range_of_dates($soap)
    {
        $this->it_sets_the_configuration($soap);

        $options = [
            'registrationDateFrom' => '2015-01-01',
            'registrationDateTo'   => '2015-02-01',
            'transactionType'      => 'lead',
        ];

        $soap->getConversionTransactions(111, $options)->willReturn(['lead']);

        $collection = $this->leadsInDates('2015-01-01', '2015-02-01');

        $collection->shouldHaveType('Illuminate\Support\Collection');

        $collection->all()->shouldReturn(['lead']);
    }

    /**
     * @testdox    It retrieves the leads achieved in a range of dates with custom options.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_retrieves_the_leads_achieved_in_a_range_of_dates_with_custom_options($soap)
    {
        $this->it_sets_the_configuration($soap);

        $options = [
            'registrationDateFrom' => '2015-01-01',
            'registrationDateTo'   => '2015-02-01',
            'transactionStatus'    => 'accepted',
            'transactionType'      => 'lead',
        ];

        $soap->getConversionTransactions(111, $options)->willReturn(['lead']);

        $collection = $this->leadsInDates('2015-01-01', '2015-02-01', ['transactionStatus' => 'accepted']);

        $collection->shouldHaveType('Illuminate\Support\Collection');

        $collection->all()->shouldReturn(['lead']);
    }
}

interface SoapMethodsToCall {

	public function authenticate($clientId, $passphrase);

    public function getConversionTransactions($siteId, $options);

}