<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\CommandDispatch\CommandHandler;
use OrderFulfillment\EventSourcing\EventStore;

class FulfillOrderHandler implements CommandHandler {

    /** @var EventStore */
    private $events;

    public function __construct(EventStore $events) {
        $this->events = $events;
    }

    public function handle($c) {
        /** @var FulfillOrder $c */
        $stream = $this->events->getStream($c->orderId());
        $order = Order::buildFrom($stream->toDomainEvents());
        $order->fulfill(
            $c->employeeId(),
            $c->fulfilledAt()
        );
        $this->events->storeStream($order->flushEvents());
    }
}
