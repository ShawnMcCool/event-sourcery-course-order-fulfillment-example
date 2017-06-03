<?php namespace spec\OrderFulfillment\LaravelEventSourcingDrivers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OrderFulfillment\EventSourcing\EventStore;

class RelationalProjectionSpec extends ObjectBehavior {

    function let(EventStore $store) {
        $this->beAnInstanceOf(TestRelationalProjection::class);
        $this->beConstructedWith($store);
    }

    function it_can_be_initialized() {
        $this->shouldHaveType(TestRelationalProjection::class);
    }
}
