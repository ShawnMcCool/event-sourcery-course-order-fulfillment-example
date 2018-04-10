<?php namespace OrderFulfillment\LatePaymentReminders;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\OrderId;

class InvoiceBecameOverdue implements DomainEvent {

    /** @var OrderId */
    private $orderId;
    /** @var string */
    private $customerName;
    /** @var Money */
    private $totalPrice;
    /** @var \DateTimeImmutable */
    private $becameOverdueAt;

    public function __construct(OrderId $orderId, string $customerName, Money $totalPrice, \DateTimeImmutable $becameOverdueAt) {
        $this->orderId         = $orderId;
        $this->customerName    = $customerName;
        $this->totalPrice      = $totalPrice;
        $this->becameOverdueAt = $becameOverdueAt;
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

    public function becameOverdueAt(): \DateTimeImmutable {
        return $this->becameOverdueAt;
    }

    public function serialize(): array {
        return [
            'orderId'         => $this->orderId->toString(),
            'customerName'    => $this->customerName,
            'totalPriceCents' => $this->totalPrice->toCents(),
            'currency'        => $this->totalPrice->currency()->toString(),
            'becameOverdueAt' => $this->becameOverdueAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new InvoiceBecameOverdue(
            OrderId::fromString($data['orderId']),
            $data['customerName'],
            Money::fromCents($data['totalPriceCents'], new Currency($data['currency'])),
            new \DateTimeImmutable($data['becameOverdueAt'])
        );
    }
}
