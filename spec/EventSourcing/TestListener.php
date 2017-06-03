<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\Listener;

class TestListener implements Listener {

    public function handle(DomainEvent $event) : void {

    }
}