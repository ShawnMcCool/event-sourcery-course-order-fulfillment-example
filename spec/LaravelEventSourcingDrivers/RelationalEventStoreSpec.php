<?php namespace spec\OrderFulfillment\LaravelEventSourcingDrivers;

use OrderFulfillment\EventSourcing\DomainEventClassMap;
use OrderFulfillment\EventSourcing\DomainEventSerializer;
use OrderFulfillment\LaravelEventSourcingDrivers\RelationalEventStore;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RelationalEventStoreSpec extends ObjectBehavior {

    function let() {
        $this->beConstructedWith(new DomainEventSerializer(new DomainEventClassMap()));
    }

    function it_is_initializable() {
        $this->shouldHaveType(RelationalEventStore::class);
    }

}