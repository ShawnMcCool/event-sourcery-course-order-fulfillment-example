<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\DomainEvent;

class TestDomainEvent implements DomainEvent {

    /** @var int */
    private $number;

    public function __construct(int $number = 0) {
        $this->number = $number;
    }

    public function serialize() : array {
        return [
            'number' => $this->number,
        ];
    }

    public static function deserialize(array $data) : DomainEvent {
        return new TestDomainEvent($data['number']);
    }

    public function number() {
        return $this->number;
    }
}
