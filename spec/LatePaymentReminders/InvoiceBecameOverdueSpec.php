<?php namespace spec\OrderFulfillment\LatePaymentReminders;

use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\OrderId;
use PhpSpec\ObjectBehavior;

class InvoiceBecameOverdueSpec extends ObjectBehavior {

    private $orderId = 'order id';
    private $customerName = 'customer name';
    private $totalPrice = '1200';
    private $currency = 'USD';
    private $becameOverdueAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedWith(
            OrderId::fromString($this->orderId),
            $this->customerName,
            Money::fromCents($this->totalPrice, new Currency($this->currency)),
            new \DateTimeImmutable($this->becameOverdueAt)
        );
    }

    function it_can_be_initialized() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->customerName()->shouldBe($this->customerName);
        $this->totalPrice()->shouldEqualValue(Money::fromCents($this->totalPrice, new Currency($this->currency)));
        $this->becameOverdueAt()->format('Y-m-d H:i:s')->shouldBe($this->becameOverdueAt);
    }

    function it_can_be_serialized() {
        $this->serialize()->shouldReturn([
            'orderId'         => $this->orderId,
            'customerName'    => $this->customerName,
            'totalPriceCents' => $this->totalPrice,
            'currency'        => $this->currency,
            'becameOverdueAt' => $this->becameOverdueAt,
        ]);
    }

    function it_can_be_deserialized() {
        $this->beConstructedThrough('deserialize', [[
            'orderId'         => 'diff order id',
            'customerName'    => 'diff customer name',
            'totalPriceCents' => '1234',
            'currency'        => 'EUR',
            'becameOverdueAt' => '2014-07-27 12:13:14',
        ]]);
        $this->orderId()->shouldEqualValue(OrderId::fromString('diff order id'));
        $this->customerName()->shouldBe('diff customer name');
        $this->totalPrice()->shouldEqualValue(Money::fromCents('1234', new Currency('EUR')));
        $this->becameOverdueAt()->format('Y-m-d H:i:s')->shouldBe('2014-07-27 12:13:14');
    }
}