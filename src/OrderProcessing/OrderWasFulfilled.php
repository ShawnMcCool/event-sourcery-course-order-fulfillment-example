<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\DomainEvent;

class OrderWasFulfilled implements DomainEvent {

    /** @var OrderId */
    private $orderId;
    /** @var EmployeeId */
    private $employeeId;
    /** @var \DateTimeImmutable */
    private $fulfilledAt;

    public function __construct(OrderId $orderId, EmployeeId $employeeId, \DateTimeImmutable $fulfilledAt) {
        $this->orderId     = $orderId;
        $this->employeeId  = $employeeId;
        $this->fulfilledAt = $fulfilledAt;
    }

    public function orderId(): OrderId {
        return $this->orderId;
    }

    public function employeeId(): EmployeeId {
        return $this->employeeId;
    }

    public function fulfilledAt(): \DateTimeImmutable {
        return $this->fulfilledAt;
    }

    public function serialize(): array {
        return [
            'orderId'     => $this->orderId->toString(),
            'employeeId'  => $this->employeeId->toString(),
            'fulfilledAt' => $this->fulfilledAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new OrderWasFulfilled(
            OrderId::fromString($data['orderId']),
            EmployeeId::fromString($data['employeeId']),
            new \DateTimeImmutable($data['fulfilledAt'])
        );
    }
}