<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\DomainEvent;

class OrderWasConfirmed implements DomainEvent {

    /** @var OrderId */
    private $orderId;
    /** @var EmployeeId */
    private $employeeId;
    /** @var \DateTimeImmutable */
    private $confirmedAt;

    public function __construct(OrderId $orderId, EmployeeId $employeeId, \DateTimeImmutable $confirmedAt) {
        $this->orderId     = $orderId;
        $this->employeeId  = $employeeId;
        $this->confirmedAt = $confirmedAt;
    }

    public function orderId(): OrderId {
        return $this->orderId;
    }

    public function employeeId(): EmployeeId {
        return $this->employeeId;
    }

    public function confirmedAt(): \DateTimeImmutable {
        return $this->confirmedAt;
    }

    public function serialize(): array {
        return [
            'orderId'     => $this->orderId->toString(),
            'employeeId'  => $this->employeeId->toString(),
            'confirmedAt' => $this->confirmedAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new OrderWasConfirmed(
            OrderId::fromString($data['orderId']),
            EmployeeId::fromString($data['employeeId']),
            new \DateTimeImmutable($data['confirmedAt'])
        );
    }
}