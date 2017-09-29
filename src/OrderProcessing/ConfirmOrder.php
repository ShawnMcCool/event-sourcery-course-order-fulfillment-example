<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\CommandDispatch\Command;

class ConfirmOrder implements Command {

    /** @var string*/
    private $orderId;
    /** @var string */
    private $employeeId;
    /** @var \DateTimeImmutable */
    private $confirmedAt;

    public function __construct($orderId, $employeeId, \DateTimeImmutable $confirmedAt) {
        $this->orderId     = $orderId;
        $this->employeeId  = $employeeId;
        $this->confirmedAt = $confirmedAt;
    }

    public function orderId(): OrderId {
        return OrderId::fromString($this->orderId);
    }

    public function employeeId(): EmployeeId {
        return EmployeeId::fromString($this->employeeId);
    }

    public function confirmedAt(): \DateTimeImmutable {
        return $this->confirmedAt;
    }
}
