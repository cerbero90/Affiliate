<?php

namespace spec\Cerbero\Affiliate\Facades\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AffiliateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Facades\Manager\Affiliate');
        $this->shouldHaveType('Illuminate\Support\Facades\Facade');
    }
}
