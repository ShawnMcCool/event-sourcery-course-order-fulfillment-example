<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\OrderId;
use PhpSpec\ObjectBehavior;

class OrderIdSpec extends ObjectBehavior {

    function it_is_initializable() {
        $this->shouldHaveType(OrderId::class);
    }
}