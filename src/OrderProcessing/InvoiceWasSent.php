<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;

class InvoiceWasSent implements DomainEvent {

    /** @var OrderId */
    private $orderId;
    /** @var string */
    private $customerName;
    /** @var Money */
    private $totalPrice;
    /** @var \DateTimeImmutable */
    private $sentAt;

    public function __construct(OrderId $orderId, string $customerName, Money $totalPrice, \DateTimeImmutable $sentAt) {
        $this->orderId      = $orderId;
        $this->customerName = $customerName;
        $this->totalPrice   = $totalPrice;
        $this->sentAt       = $sentAt;
    }

    public function orderId(): OrderId {
        return $this->orderId;
    }

    public function customerName(): string {
        return $this->customerName;
    }

    public function totalPrice(): Money {
        return $this->totalPrice;
    }

    public function sentAt(): \DateTimeImmutable {
        return $this->sentAt;
    }

    public function serialize(): array {
        return [
            'orderId'         => $this->orderId->toString(),
            'customerName'    => $this->customerName,
            'totalPriceCents' => $this->totalPrice->toCents(),
            'currency'        => $this->totalPrice->currency()->toString(),
            'sentAt'          => $this->sentAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new InvoiceWasSent(
            OrderId::fromString($data['orderId']),
            $data['customerName'],
            Money::fromCents($data['totalPriceCents'], new Currency($data['currency'])),
            new \DateTimeImmutable($data['sentAt'])
        );
    }
}
