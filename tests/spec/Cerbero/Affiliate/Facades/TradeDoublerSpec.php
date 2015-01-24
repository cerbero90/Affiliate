<?php

namespace spec\Cerbero\Affiliate\Facades;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TradeDoublerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Facades\TradeDoubler');
        $this->shouldHaveType('Illuminate\Support\Facades\Facade');
    }
}
