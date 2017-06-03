<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\Aggregate;
use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\Id;
use OrderFulfillment\EventSourcing\StreamId;

class TestAggregate extends Aggregate {

    // this value in incremented by events
    private $number = 0;

    public static function create() {
        return new static;
    }

    public function appliedEventCount() : int {
        return $this->number;
    }

    public function raiseEvent(DomainEvent $event) {
        $this->raise($event);
    }

    // returns an arbitrary Id
    public function id() : Id {
        return StreamId::fromString("id");
    }

    protected function applyTestCountingEvent(TestCountingEvent $e) {
        $this->number += $e->number();
    }
}
