<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\CommandDispatch\Command;
use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;

class PlaceOrder implements Command {

    /** @var */
    private $orderId;
    /** @var */
    private $customerId;
    /** @var */
    private $customerName;
    /** @var */
    private $products;
    /** @var */
    private $totalPriceCents;
    /** @var */
    private $currency;
    /** @var \DateTimeImmutable */
    private $placedAt;

    public function __construct($orderId, $customerId, $customerName, $products, $totalPriceCents, $currency, \DateTimeImmutable $placedAt) {
        $this->orderId = $orderId;
        $this->customerId = $customerId;
        $this->customerName = $customerName;
        $this->products = $products;
        $this->totalPriceCents = $totalPriceCents;
        $this->currency = $currency;
        $this->placedAt = $placedAt;
    }

    public function orderId(): OrderId {
        return OrderId::fromString($this->orderId);
    }

    public function customerId(): CustomerId {
        return CustomerId::fromString($this->customerId);
    }

    public function customerName(): string {
        return $this->customerName;
    }

    public function products(): array {
        return array_map(function(string $productId) {
            return ProductId::fromString($productId);
        }, $this->products);
    }

    public function totalPrice(): Money {
        return Money::fromCents($this->totalPriceCents, new Currency($this->currency));
    }

    public function placedAt(): \DateTimeImmutable {
        return $this->placedAt;
    }
}
