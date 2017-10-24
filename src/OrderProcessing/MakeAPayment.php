<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\CommandDispatch\Command;
use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;

class MakeAPayment implements Command
{
    /** @var */
    private $orderId;
    /** @var */
    private $amountCents;
    /** @var */
    private $currency;
    /** @var */
    private $paidAt;

    public function __construct($orderId, $amountCents, $currency, \DateTimeImmutable $paidAt) {
        $this->orderId     = $orderId;
        $this->amountCents = $amountCents;
        $this->currency    = $currency;
        $this->paidAt      = $paidAt;
    }

    public function orderId(): OrderId {
        return OrderId::fromString($this->orderId);
    }

    public function amount(): Money {
        return Money::fromCents($this->amountCents, new Currency($this->currency));
    }

    public function paidAt(): \DateTimeImmutable {
        return $this->paidAt;
    }
}
