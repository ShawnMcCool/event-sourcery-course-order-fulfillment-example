<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\CommandDispatch\Command;

class FulfillOrder implements Command {

    /** @var string */
    private $orderId;
    /** @var string */
    private $employeeId;
    /** @var \DateTimeImmutable */
    private $fulfilledAt;

    public function __construct($orderId, $employeeId, \DateTimeImmutable $fulfilledAt) {
        $this->orderId     = $orderId;
        $this->employeeId  = $employeeId;
        $this->fulfilledAt = $fulfilledAt;
    }

    public function orderId(): OrderId {
        return OrderId::fromString($this->orderId);
    }

    public function employeeId(): EmployeeId {
        return EmployeeId::fromString($this->employeeId);
    }

    public function fulfilledAt(): \DateTimeImmutable {
        return $this->fulfilledAt;
    }
}