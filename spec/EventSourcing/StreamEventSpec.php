<?php namespace spec\OrderFulfillment\EventSourcing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OrderFulfillment\EventSourcing\StreamId;
use OrderFulfillment\EventSourcing\StreamVersion;

class StreamEventSpec extends ObjectBehavior {

    function it_is_initializable() {
        $this->beConstructedWith(StreamId::fromString('id'), StreamVersion::fromInt(1), new TestDomainEvent());
        $this->id()->shouldEqualValue(StreamId::fromString('id'));
        $this->event()->shouldHaveType(TestDomainEvent::class);
        $this->version()->shouldEqualValue(StreamVersion::fromInt(1));
    }
}
