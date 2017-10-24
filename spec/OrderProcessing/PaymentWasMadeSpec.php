<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\OrderId;
use PhpSpec\ObjectBehavior;

class PaymentWasMadeSpec extends ObjectBehavior {

    private $orderId = 'order id';
    private $amountCents = '1231';
    private $amountCurrency = 'EUR';
    private $paidAt = '2017-01-01 23:25:23';

    function let() {
        $this->beConstructedWith(
            OrderId::fromString($this->orderId),
            Money::fromCents($this->amountCents, new Currency($this->amountCurrency)),
            new \DateTimeImmutable($this->paidAt)
        );
    }

    function it_can_be_initialized() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->amount()->shouldEqualValue(Money::fromCents($this->amountCents, new Currency($this->amountCurrency)));
        $this->paidAt()->format('Y-m-d H:i:s')->shouldBe($this->paidAt);
    }

    function it_can_be_serialized() {
        $this->serialize()->shouldReturn([
            'orderId'        => $this->orderId,
            'amountCents'    => $this->amountCents,
            'amountCurrency' => $this->amountCurrency,
            'paidAt'         => $this->paidAt,
        ]);
    }

    function it_can_be_deserialized() {
        $this->beConstructedThrough('deserialize', [[
            'orderId'        => 'diff order id',
            'amountCents'    => '1234',
            'amountCurrency' => 'USD',
            'paidAt'         => '2014-07-27 12:13:44',
        ]]);
        $this->orderId()->shouldEqualValue(OrderId::fromString('diff order id'));
        $this->amount()->shouldEqualValue(Money::fromCents('1234', new Currency('USD')));
        $this->paidAt()->format('Y-m-d H:i:s')->shouldBe('2014-07-27 12:13:44');
    }
}
