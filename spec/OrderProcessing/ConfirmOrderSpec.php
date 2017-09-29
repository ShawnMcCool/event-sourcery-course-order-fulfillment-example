<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\ConfirmOrder;
use OrderFulfillment\OrderProcessing\EmployeeId;
use OrderFulfillment\OrderProcessing\OrderId;
use PhpSpec\ObjectBehavior;

class ConfirmOrderSpec extends ObjectBehavior {

    private $orderId = 'order id';
    private $employeeId = 'employee id';
    private $confirmedAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedWith($this->orderId, $this->employeeId, new \DateTimeImmutable($this->confirmedAt));
    }

    function it_is_initializable() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->employeeId()->shouldEqualValue(EmployeeId::fromString($this->employeeId));
        $this->confirmedAt()->format('Y-m-d H:i:s')->shouldBe($this->confirmedAt);
    }
}
