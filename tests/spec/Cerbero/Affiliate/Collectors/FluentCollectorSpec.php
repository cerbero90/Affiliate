<?php

namespace spec\Cerbero\Affiliate\Collectors;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FluentCollectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Affiliate\Collectors\FluentCollector');
        $this->shouldHaveType('Cerbero\Affiliate\Collectors\CollectorInterface');
    }

    /**
     * @testdox	It can collect arrays.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_can_collect_arrays()
    {
    	$array = [ ['foo' => 'bar'] ];

    	$this->collect($array);

    	$this->checkCollectorReturnsCollectionWithOneFluentObject();
    }

    /**
     * @testdox	It can collect objects.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_can_collect_objects()
    {
    	$obj = new \StdClass;

    	$obj->foo = 'bar';

    	$this->collect([$obj]);

    	$this->checkCollectorReturnsCollectionWithOneFluentObject();
    }

    /**
     * @testdox	It throws an exception when trying to collect something different from an array or object.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_throws_an_exception_when_trying_to_collect_something_different_from_an_array_or_object()
    {
    	$this->shouldThrow('\InvalidArgumentException')->duringCollect([1]);
    }

    /**
     * Check the collector returns a collection that contains a Fluent object.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    private function checkCollectorReturnsCollectionWithOneFluentObject()
    {
    	$collection = $this->getCollection();

    	$collection->shouldHaveType('Illuminate\Support\Collection');

    	$collection->count()->shouldReturn(1);

    	$object = $collection->first();

    	$object->shouldHaveType('Illuminate\Support\Fluent');

    	$object->foo->shouldBe('bar');
    }
}
