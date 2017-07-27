<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\CommandDispatch\CommandHandler;
use OrderFulfillment\EventSourcing\EventStore;

class PlaceOrderHandler implements CommandHandler {

    /** @var EventStore */
    private $events;

    public function __construct(EventStore $events) {
        $this->events = $events;
    }

    public function handle($c) {

    }
}
