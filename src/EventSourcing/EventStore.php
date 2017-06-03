<?php namespace OrderFulfillment\EventSourcing;

interface EventStore {

    public function storeStream(StreamEvents $events) : void;
    public function storeEvent(DomainEvent $event) : void;
    public function allFor(StreamId $id) : DomainEvents;
}
