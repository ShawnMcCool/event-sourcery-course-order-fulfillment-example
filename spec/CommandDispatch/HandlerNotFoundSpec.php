<?php namespace spec\OrderFulfillment\CommandDispatch;

use OrderFulfillment\CommandDispatch\HandlerNotFound;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HandlerNotFoundSpec extends ObjectBehavior {
    function it_is_initializable() {
        $this->shouldHaveType(HandlerNotFound::class);
    }
}
