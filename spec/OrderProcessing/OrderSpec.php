<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\CustomerId;
use OrderFulfillment\OrderProcessing\Order;
use OrderFulfillment\OrderProcessing\OrderId;
use OrderFulfillment\OrderProcessing\OrderWasPlaced;
use OrderFulfillment\OrderProcessing\ProductId;
use PhpSpec\ObjectBehavior;

class OrderSpec extends ObjectBehavior {

    private $orderId = 'group id';
    private $customerId = 'customer id';
    private $customerName = 'customer name';
    private $products = ['product id 1', 'product id 2'];
    private $totalPriceCents = '1200';
    private $currency = 'usd';
    private $placedAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedThrough('place', [
            OrderId::fromString($this->orderId),
            CustomerId::fromString($this->customerId),
            $this->customerName,
            array_map(function($productId) {
                return ProductId::fromString($productId);
            }, $this->products),
            Money::fromCents($this->totalPriceCents, new Currency($this->currency)),
            new \DateTimeImmutable($this->placedAt)
        ]);
    }
    function it_places_orders() {
        $this->flushEvents()->shouldContainEvent(
            new OrderWasPlaced(
                OrderId::fromString($this->orderId),
                CustomerId::fromString($this->customerId),
                $this->customerName,
                array_map(function($productId) {
                    return ProductId::fromString($productId);
                }, $this->products),
                Money::fromCents($this->totalPriceCents, new Currency($this->currency)),
                new \DateTimeImmutable($this->placedAt)
            )
        );
    }
}