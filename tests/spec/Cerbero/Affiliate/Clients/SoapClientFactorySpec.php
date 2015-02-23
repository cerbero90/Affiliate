<?php

namespace spec\Cerbero\Affiliate\Clients;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SoapClientFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Clients\SoapClientFactory');
    }

    /**
     * @testdox	It sets and gets the location of the web service.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sets_and_gets_the_location_of_the_web_service()
    {
    	$this->setLocation('foo');

    	$this->getLocation()->shouldReturn('foo');
    }

    /**
     * @testdox	It sets and gets the headers of the calling.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sets_and_gets_the_headers_of_the_calling()
    {
    	$this->setHeaders(['foo']);

    	$this->getHeaders()->shouldReturn(['foo']);
    }

    /**
     * @testdox	It creates a soap client with the set location and headers.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_creates_a_soap_client_with_the_set_location_and_headers()
    {
    	$this->setLocation('http://ws.tradetracker.com/soap/affiliate?wsdl');

    	$this->setHeaders([]);

    	$this->make()->shouldHaveType('\SoapClient');
    }
}
