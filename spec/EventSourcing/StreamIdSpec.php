<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\StreamId;
use PhpSpec\ObjectBehavior;

class StreamIdSpec extends ObjectBehavior {
    public function it_is_initializable() {
        $this->shouldHaveType(StreamId::class);
    }
}