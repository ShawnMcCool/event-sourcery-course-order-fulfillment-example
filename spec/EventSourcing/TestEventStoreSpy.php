<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\DomainEvents;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\StreamEvent;
use OrderFulfillment\EventSourcing\StreamEvents;
use OrderFulfillment\EventSourcing\StreamId;

class TestEventStoreSpy implements EventStore {

    private $events = [];

    public function storeStream(StreamEvents $events) : void {
        $this->events = array_merge($this->events,
            $events->map(function(StreamEvent $streamEvent) {
                return $streamEvent->event();
            })->toArray()
        );
    }

    public function storeEvent(DomainEvent $event) : void {
        $this->events[] = $event;
    }

    public function allFor(StreamId $id) : DomainEvents {

    }

    public function storedEvents(): DomainEvents {
        return DomainEvents::make($this->events);
    }
}