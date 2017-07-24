<?php

namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\ProductId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProductId::class);
    }
}
