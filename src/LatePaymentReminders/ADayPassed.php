<?php namespace OrderFulfillment\LatePaymentReminders;

use OrderFulfillment\EventSourcing\DomainEvent;

class ADayPassed implements DomainEvent {

    /** @var \DateTimeImmutable */
    private $completedDate;

    public function __construct(\DateTimeImmutable $completedDate) {
        $this->completedDate = $completedDate;
    }

    public function completedDate(): \DateTimeImmutable {
        return $this->completedDate;
    }

    public function serialize(): array {
        return [
            'completedDate' => $this->completedDate->format('Y-m-d')
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new static(new \DateTimeImmutable($data['completedDate']));
    }
}
