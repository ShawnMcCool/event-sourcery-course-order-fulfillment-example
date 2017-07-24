<?php namespace spec\OrderFulfillment\PhpSpec;

use OrderFulfillment\EventSourcing\DomainEvent;

class EventStub implements DomainEvent {

    /** @var */
    private $a;
    /** @var */
    private $b;
    /** @var */
    private $c;

    public function __construct($a, $b, $c) {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function serialize(): array {

    }

    public static function deserialize(array $data): DomainEvent {

    }
}