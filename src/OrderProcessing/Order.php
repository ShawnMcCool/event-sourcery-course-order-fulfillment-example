<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\Aggregate;
use OrderFulfillment\EventSourcing\Id;
use OrderFulfillment\Money\Money;

class Order extends Aggregate {

    // raise
    public static function place(OrderId $orderId, CustomerId $customerId, string $customerName, array $products, Money $totalPrice, \DateTimeImmutable $placedAt) {
        $order = new Order;
        $order->raise(
            new OrderWasPlaced($orderId, $customerId, $customerName, $products, $totalPrice, $placedAt)
        );
        return $order;
    }

    // apply
    private $orderId;

    public function applyOrderWasPlaced(OrderWasPlaced $e) {
        $this->orderId = $e->orderId();
    }

    // read
    public function id(): Id {
        return $this->orderId;
    }
}
