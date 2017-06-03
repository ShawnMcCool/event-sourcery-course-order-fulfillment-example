<?php namespace OrderFulfillment\EventSourcing;

interface Listener {
    public function handle(DomainEvent $event) : void;
}
