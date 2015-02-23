<?php

namespace spec\Cerbero\Affiliate\Facades;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TradeTrackerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Facades\TradeTracker');
        $this->shouldHaveType('Illuminate\Support\Facades\Facade');
    }
}
