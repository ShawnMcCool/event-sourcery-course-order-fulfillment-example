<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\DomainEvent;

class OrderWasCompleted implements DomainEvent {

    /** @var OrderId */
    private $orderId;
    /** @var \DateTimeImmutable */
    private $completedAt;

    public function __construct(OrderId $orderId, \DateTimeImmutable $completedAt) {
        $this->orderId     = $orderId;
        $this->completedAt = $completedAt;
    }

    public function orderId(): OrderId {
        return $this->orderId;
    }

    public function completedAt(): \DateTimeImmutable {
        return $this->completedAt;
    }

    public function serialize(): array {
        return [
            'orderId'     => $this->orderId->toString(),
            'completedAt' => $this->completedAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new OrderWasCompleted(
            OrderId::fromString($data['orderId']),
            new \DateTimeImmutable($data['completedAt'])
        );
    }
}