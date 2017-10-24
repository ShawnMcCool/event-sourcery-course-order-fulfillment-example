<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\OrderId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MakeAPaymentSpec extends ObjectBehavior
{
    private $orderId = 'order id';
    private $amountCents = '1231';
    private $currency = 'EUR';
    private $paidAt = '2017-01-01 23:25:23';

    function let() {
        $this->beConstructedWith($this->orderId, $this->amountCents, $this->currency, new \DateTimeImmutable($this->paidAt));
    }

    function it_is_initializable() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->amount()->shouldEqualValue(
            Money::fromCents($this->amountCents, new Currency($this->currency))
        );
        $this->paidAt()->format('Y-m-d H:i:s')->shouldBe($this->paidAt);
    }
}
