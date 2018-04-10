<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\OrderId;
use PhpSpec\ObjectBehavior;

class OrderWasCompletedSpec extends ObjectBehavior {

    private $orderId = 'order id';
    private $completedAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedWith(
            OrderId::fromString($this->orderId),
            new \DateTimeImmutable($this->completedAt)
        );
    }

    function it_can_be_initialized() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->completedAt()->format('Y-m-d H:i:s')->shouldBe($this->completedAt);
    }

    function it_can_be_serialized() {
        $this->serialize()->shouldReturn([
            'orderId'     => $this->orderId,
            'completedAt' => $this->completedAt,
        ]);
    }

    function it_can_be_deserialized() {
        $this->beConstructedThrough('deserialize', [[
            'orderId'         => 'diff order id',
            'completedAt'     => '2014-07-27 12:13:14',
        ]]);
        $this->orderId()->shouldEqualValue(OrderId::fromString('diff order id'));
        $this->completedAt()->format('Y-m-d H:i:s')->shouldBe('2014-07-27 12:13:14');
    }
}