<?php namespace spec\OrderFulfillment\EventSourcing;

use PhpSpec\ObjectBehavior;

class ListenersSpec extends ObjectBehavior {

    function it_can_hold_listeners() {
        $this->beConstructedThrough('make', [[new TestListener(), new TestListener()]]);
        $this->count()->shouldBe(2);
    }

    function it_cant_hold_anything_else() {
        $this->beConstructedThrough('make', [[TestId::fromString('1')]]);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

}