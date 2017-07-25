<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;

class OrderWasPlaced implements DomainEvent {

    /** @var OrderId */
    private $orderId;
    /** @var CustomerId */
    private $customerId;
    /** @var string */
    private $customerName;
    /** @var array */
    private $products;
    /** @var Money */
    private $totalPrice;
    /** @var \DateTimeImmutable */
    private $placedAt;

    public function __construct(OrderId $orderId, CustomerId $customerId, string $customerName, array $products, Money $totalPrice, \DateTimeImmutable $placedAt) {
        $this->orderId      = $orderId;
        $this->customerId   = $customerId;
        $this->customerName = $customerName;
        $this->products     = $products;
        $this->totalPrice   = $totalPrice;
        $this->placedAt     = $placedAt;
    }

    public function orderId(): OrderId {
        return $this->orderId;
    }

    public function customerId(): CustomerId {
        return $this->customerId;
    }

    public function customerName(): string {
        return $this->customerName;
    }

    public function products(): array {
        return $this->products;
    }

    public function totalPrice(): Money {
        return $this->totalPrice;
    }

    public function placedAt(): \DateTimeImmutable {
        return $this->placedAt;
    }

    public function serialize(): array {
        return [
            'orderId'         => $this->orderId->toString(),
            'customerId'      => $this->customerId->toString(),
            'customerName'    => $this->customerName,
            'products'        => array_map(function (ProductId $product) {
                return $product->toString();
            }, $this->products),
            'totalPriceCents' => $this->totalPrice->toCents(),
            'currency'        => $this->totalPrice->currency()->toString(),
            'placedAt'        => $this->placedAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new OrderWasPlaced(
            OrderId::fromString($data['orderId']),
            CustomerId::fromString($data['customerId']),
            $data['customerName'],
            array_map(function($productId) {
                return ProductId::fromString($productId);
            }, $data['products']),
            Money::fromCents($data['totalPriceCents'], new Currency($data['currency'])),
            new \DateTimeImmutable($data['placedAt'])
        );
    }
}