<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\DomainEvents;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\StreamEvent;
use OrderFulfillment\EventSourcing\StreamEvents;
use OrderFulfillment\EventSourcing\StreamId;

class TestEventStoreSpy implements EventStore {

    private $events = [];

    public function storeStream(StreamEvents $events): void {
        $this->events = array_merge($this->events,
            $events->map(function (StreamEvent $streamEvent) {
                return $streamEvent->event();
            })->toArray()
        );
    }

    public function storeEvent(DomainEvent $event): void {
        $this->events[] = $event;
    }

    public function getStream(StreamId $id): StreamEvents {

    }

    public function storedEvents(): DomainEvents {
        return DomainEvents::make($this->events);
    }

    public function getEvents($take = 0, $skip = 0): DomainEvents {

    }
}