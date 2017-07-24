<?php

namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\EmployeeId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmployeeIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EmployeeId::class);
    }
}
