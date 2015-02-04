<?php

namespace spec\Cerbero\Affiliate\Facades;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ZanoxSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Facades\Zanox');
        $this->shouldHaveType('Illuminate\Support\Facades\Facade');
    }
}
