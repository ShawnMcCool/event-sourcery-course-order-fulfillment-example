<?php namespace OrderFulfillment\EventSourcing;

interface EventDispatcher {

    public function addListener(Listener $listener): void;
    public function dispatch(DomainEvents $events): void;
}
