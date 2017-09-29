<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\StreamEvent;
use OrderFulfillment\EventSourcing\StreamEvents;
use OrderFulfillment\EventSourcing\StreamId;
use OrderFulfillment\EventSourcing\StreamVersion;
use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\CustomerId;
use OrderFulfillment\OrderProcessing\OrderId;
use OrderFulfillment\OrderProcessing\OrderWasPlaced;
use OrderFulfillment\OrderProcessing\ProductId;

class OrderStreamBuilder {

    private $orderId = 'order id';
    private $customerId = 'customer id';
    private $customerName = 'customer name';
    private $products = ['product id 1', 'product id 2'];
    private $totalPrice = '1200';
    private $currency = 'USD';
    private $placedAt = '2017-01-01 23:21:23';

    public function placeOrder($orderId) {
        return StreamEvents::make([
            new StreamEvent(
                StreamId::generate(),
                StreamVersion::fromInt(1),
                new OrderWasPlaced(
                    OrderId::fromString($orderId),
                    CustomerId::fromString($this->customerId),
                    $this->customerName,
                    array_map(function ($productId) {
                        return ProductId::fromString($productId);
                    }, $this->products),
                    Money::fromCents($this->totalPrice, new Currency($this->currency)),
                    new \DateTimeImmutable($this->placedAt)
                )
            )
        ]);
    }
}