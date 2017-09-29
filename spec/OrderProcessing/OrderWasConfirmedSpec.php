<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\EmployeeId;
use OrderFulfillment\OrderProcessing\OrderId;
use PhpSpec\ObjectBehavior;

class OrderWasConfirmedSpec extends ObjectBehavior {

    private $orderId = 'order id';
    private $employeeId = 'employee id';
    private $confirmedAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedWith(
            OrderId::fromString($this->orderId),
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );
    }

    function it_can_be_initialized() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->employeeId()->shouldEqualValue(EmployeeId::fromString($this->employeeId));
        $this->confirmedAt()->format('Y-m-d H:i:s')->shouldBe($this->confirmedAt);
    }

    function it_can_be_serialized() {
        $this->serialize()->shouldReturn([
            'orderId'     => $this->orderId,
            'employeeId'  => $this->employeeId,
            'confirmedAt' => $this->confirmedAt,
        ]);
    }

    function it_can_be_deserialized() {
        $this->beConstructedThrough('deserialize', [[
            'orderId'     => 'diff order id',
            'employeeId'  => 'diff employee id',
            'confirmedAt' => '2014-07-27 12:13:14',
        ]]);
        $this->orderId()->shouldEqualValue(OrderId::fromString('diff order id'));
        $this->employeeId()->shouldEqualValue(EmployeeId::fromString('diff employee id'));
        $this->confirmedAt()->format('Y-m-d H:i:s')->shouldBe('2014-07-27 12:13:14');
    }
}
