<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\Aggregate;
use OrderFulfillment\EventSourcing\Id;
use OrderFulfillment\Money\Currency;
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

    public function makePayment(Money $amount, \DateTimeImmutable $paidAt) {
        if ($this->totalAmountPaid->add($amount)->isGreaterThan($this->totalOrderPrice)) {
            throw new CannotPayMoreThanTotal("Tried to make a payment larger than the total price for order " . $this->orderId->toString());
        }
        $this->raise(
            new PaymentWasMade(
                $this->orderId,
                $amount,
                $paidAt
            )
        );
    }

    // apply
    /** @var OrderId $orderId */
    private $orderId;
    private $status;
    /** @var Money $totalAmountPaid */
    private $totalAmountPaid;
    /** @var Money $totalOrderPrice */
    private $totalOrderPrice;

    protected function applyOrderWasPlaced(OrderWasPlaced $e) {
        $this->orderId = $e->orderId();
        $this->status  = "placed";
        $this->totalAmountPaid = Money::fromCents(0, $e->totalPrice()->currency());
        $this->totalOrderPrice = $e->totalPrice();
    }

    protected function applyOrderWasConfirmed(OrderWasConfirmed $e) {
        $this->status = "confirmed";
    }

    protected function applyPaymentWasMade(PaymentWasMade $e) {
        $this->totalAmountPaid = $this->totalAmountPaid->add($e->amount());
    }

    // read
    public function id(): Id {
        return $this->orderId;
    }
}
