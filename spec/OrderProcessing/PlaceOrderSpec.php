<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\CustomerId;
use OrderFulfillment\OrderProcessing\OrderId;
use OrderFulfillment\OrderProcessing\PlaceOrder;
use OrderFulfillment\OrderProcessing\ProductId;
use PhpSpec\ObjectBehavior;

class PlaceOrderSpec extends ObjectBehavior {

    private $orderId = 'order id';
    private $customerId = 'customer id';
    private $customerName = 'customer name';
    private $products = ['product id 1', 'product id 2'];
    private $totalPriceCents = '1200';
    private $currency = 'usd';
    private $placedAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedWith($this->orderId, $this->customerId, $this->customerName, $this->products, $this->totalPriceCents, $this->currency, new \DateTimeImmutable($this->placedAt));
    }

    function it_is_initializable() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->customerId()->shouldEqualValue(CustomerId::fromString($this->customerId));
        $this->customerName()->shouldBe($this->customerName);
        $this->products()->shouldEqualValues(
            ProductId::fromString('product id 1'),
            ProductId::fromString('product id 2')
        );
        $this->totalPrice()->shouldEqualValue(
            Money::fromCents($this->totalPriceCents, new Currency('usd'))
        );
        $this->placedAt()->format('Y-m-d H:i:s')->shouldBe($this->placedAt);
    }
}
