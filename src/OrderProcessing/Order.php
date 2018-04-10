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

        $this->raise(
            new InvoiceWasSent(
                $this->orderId,
                $this->customerName,
                $this->totalOrderPrice,
                $confirmedAt
            )
        );
    }

    public function makePayment(Money $amount, \DateTimeImmutable $paidAt): void {
        if ($this->status != "confirmed") {
            throw new CannotMakePaymentsOnUnconfirmedOrders($this->orderId->toString());
        }
        $subtotal = $this->totalAmountPaid->add($amount);
        if ($subtotal->isGreaterThan($this->totalOrderPrice)) {
            throw new CannotPayMoreThanTotal("Tried to make a payment larger than the total price for order " . $this->orderId->toString() . ' Payment was ' . $amount->toString() . ' subtotal was ' . $subtotal->toString() . ' and total price was ' . $this->totalOrderPrice->toString());
        }
        $this->raise(
            new PaymentWasMade(
                $this->orderId,
                $amount,
                $paidAt
            )
        );
        if ($subtotal->equals($this->totalOrderPrice)) {
            $this->raise(
                new OrderWasCompleted(
                    $this->orderId,
                    $paidAt
                )
            );
        }
    }

    public function fulfill(EmployeeId $employeeId, \DateTimeImmutable $fulfilledAt): void {
        if ($this->status != "completed") {
            throw new CannotFulfillAnOrderThatHasNotBeenCompleted($this->orderId->toString());
        }

        $this->raise(
            new OrderWasFulfilled(
                $this->orderId,
                $employeeId,
                $fulfilledAt
            )
        );
    }

    // apply
    /** @var OrderId $orderId */
    private $orderId;
    /** @var string $status */
    private $status;
    /** @var Money $totalAmountPaid */
    private $totalAmountPaid;
    /** @var Money $totalOrderPrice */
    private $totalOrderPrice;
    /** @var string $customerName */
    private $customerName;

    protected function applyOrderWasPlaced(OrderWasPlaced $e) {
        $this->orderId = $e->orderId();
        $this->status  = "placed";
        $this->totalAmountPaid = Money::fromCents(0, $e->totalPrice()->currency());
        $this->totalOrderPrice = $e->totalPrice();
        $this->customerName = $e->customerName();
    }

    protected function applyOrderWasConfirmed(OrderWasConfirmed $e) {
        $this->status = "confirmed";
    }

    protected function applyPaymentWasMade(PaymentWasMade $e) {
        $this->totalAmountPaid = $this->totalAmountPaid->add($e->amount());
    }

    protected function applyOrderWasCompleted(OrderWasCompleted $e) {
        $this->status = 'completed';
    }

    protected function applyOrderWasFulfilled(OrderWasFulfilled $e) {
        $this->status = 'fulfilled';
    }

    protected function applyInvoiceWasSent(InvoiceWasSent $e) {}

    // read
    public function id(): Id {
        return $this->orderId;
    }
}