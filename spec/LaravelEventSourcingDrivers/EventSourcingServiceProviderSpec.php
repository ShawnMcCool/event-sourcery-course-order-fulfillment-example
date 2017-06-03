<?php namespace spec\OrderFulfillment\LaravelEventSourcingDrivers;

use OrderFulfillment\LaravelEventSourcingDrivers\EventSourcingServiceProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventSourcingServiceProviderSpec extends ObjectBehavior {

    function it_is_initializable() {
        $this->beConstructedWith('laravel container');
        $this->shouldHaveType(EventSourcingServiceProvider::class);
    }
}
