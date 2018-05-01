<?php namespace OrderFulfillment\LatePaymentReminders;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\OrderProcessing\OrderId;

class InvoiceBecameExtremelyOverdue implements DomainEvent {

    /** @var OrderId */
    private $orderId;
    /** @var \DateTimeImmutable */
    private $becameOverdueAt;

    public function __construct(OrderId $orderId, \DateTimeImmutable $becameOverdueAt) {
        $this->orderId         = $orderId;
        $this->becameOverdueAt = $becameOverdueAt;
    }

    public function orderId(): OrderId {
        return $this->orderId;
    }

    public function becameOverdueAt(): \DateTimeImmutable {
        return $this->becameOverdueAt;
    }

    public function serialize(): array {
        return [
            'orderId'         => $this->orderId->toString(),
            'becameOverdueAt' => $this->becameOverdueAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new static(
            OrderId::fromString($data['orderId']),
            new \DateTimeImmutable($data['becameOverdueAt'])
        );
    }
}
