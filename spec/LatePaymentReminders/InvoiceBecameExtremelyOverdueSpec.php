<?php namespace spec\OrderFulfillment\LatePaymentReminders;

class InvoiceBecameExtremelyOverdueSpec {

    private $orderId = 'order id';
    private $becameOverdueAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedWith(
            OrderId::fromString($this->orderId),
            new \DateTimeImmutable($this->becameOverdueAt)
        );
    }

    function it_can_be_initialized() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->becameOverdueAt()->format('Y-m-d H:i:s')->shouldBe($this->becameOverdueAt);
    }

    function it_can_be_serialized() {
        $this->serialize()->shouldReturn([
            'orderId'         => $this->orderId,
            'becameOverdueAt' => $this->becameOverdueAt,
        ]);
    }

    function it_can_be_deserialized() {
        $this->beConstructedThrough('deserialize', [[
            'orderId'         => 'diff order id',
            'becameOverdueAt' => '2014-07-27 12:13:14',
        ]]);
        $this->orderId()->shouldEqualValue(OrderId::fromString('diff order id'));
        $this->becameOverdueAt()->format('Y-m-d H:i:s')->shouldBe('2014-07-27 12:13:14');
    }
}