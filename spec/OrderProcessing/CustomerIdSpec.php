<?php

namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\CustomerId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CustomerIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerId::class);
    }
}
