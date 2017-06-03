<?php namespace OrderFulfillment\EventSourcing;

class DomainEvents extends TypedCollection {

    protected $collectionType = DomainEvent::class;
}