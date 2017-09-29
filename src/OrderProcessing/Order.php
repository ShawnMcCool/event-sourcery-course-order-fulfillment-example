<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\Aggregate;
use OrderFulfillment\EventSourcing\Id;
use OrderFulfillment\Money\Money;

class Order extends Aggregate {

    // raise
    public static function place(OrderId $orderId, CustomerId $customerId, string $customerName, array $products, Money $totalPrice, \DateTimeImmutable $placedAt): Order {
        $order = new Order;
        $order->raise(
            new OrderWasPlaced($orderId, $customerId, $customerName, $products, $totalPrice, $placedAt)
        );
        return $order;
    }

    public function confirm(EmployeeId $employeeId, \DateTimeImmutable $confirmedAt): void {
        if ($this->status != "placed") {
            throw new CannotConfirmOrderMoreThanOnce($this->orderId->toString());
        }

        $this->raise(
            new OrderWasConfirmed(
                $this->orderId,
                $employeeId,
                $confirmedAt
            )
        );
    }

    // apply
    private $orderId;
    private $status;

    protected function applyOrderWasPlaced(OrderWasPlaced $e) {
        $this->orderId = $e->orderId();
        $this->status  = "placed";
    }

    protected function applyOrderWasConfirmed(OrderWasConfirmed $e) {
        $this->status = "confirmed";
    }

    // read
    public function id(): Id {
        return $this->orderId;
    }
}
