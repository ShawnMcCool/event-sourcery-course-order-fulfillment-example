<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\StreamEvent;
use OrderFulfillment\EventSourcing\StreamEvents;
use OrderFulfillment\EventSourcing\StreamId;
use OrderFulfillment\EventSourcing\StreamVersion;
use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\CustomerId;
use OrderFulfillment\OrderProcessing\EmployeeId;
use OrderFulfillment\OrderProcessing\OrderId;
use OrderFulfillment\OrderProcessing\OrderWasCompleted;
use OrderFulfillment\OrderProcessing\OrderWasConfirmed;
use OrderFulfillment\OrderProcessing\OrderWasPlaced;
use OrderFulfillment\OrderProcessing\PaymentWasMade;
use OrderFulfillment\OrderProcessing\ProductId;

class OrderStreamBuilder {

    private $orderId = 'order id';
    private $customerId = 'customer id';
    private $customerName = 'customer name';
    private $products = ['product id 1', 'product id 2'];
    private $totalPrice = '1200';
    private $currency = 'USD';
    private $placedAt = '2017-01-01 23:21:23';

    public function placeOrder(string $orderId): StreamEvents {
        return StreamEvents::make([
            new StreamEvent(
                StreamId::fromString($orderId),
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
            ),
        ]);
    }

    public function confirmOrder(StreamEvents $stream, string $orderId): StreamEvents {
        return $stream->add(new StreamEvent(
            StreamId::fromString($orderId),
            StreamVersion::fromInt(1),
            new OrderWasConfirmed(
                OrderId::fromString($orderId),
                EmployeeId::generate(),
                new \DateTimeImmutable($this->placedAt)
            )
        ));
    }

    public function completeOrder(StreamEvents $stream, string $orderId): StreamEvents {
        return $stream
            ->add(
                new StreamEvent(
                    StreamId::fromString($orderId),
                    StreamVersion::fromInt(2),
                    new PaymentWasMade(
                        OrderId::fromString($orderId),
                        Money::fromCents($this->totalPrice, new Currency($this->currency)),
                        new \DateTimeImmutable($this->placedAt)
                    )
                )
            )
            ->add(
                new StreamEvent(
                    StreamId::fromString($orderId),
                    StreamVersion::fromInt(3),
                    new OrderWasCompleted(
                        OrderId::fromString($orderId),
                        new \DateTimeImmutable($this->placedAt)
                    )
                )
            );
    }
}