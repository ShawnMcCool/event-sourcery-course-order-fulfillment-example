<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\CommandDispatch\CommandHandler;
use OrderFulfillment\EventSourcing\EventStore;

class ConfirmOrderHandler implements CommandHandler {

    /** @var EventStore */
    private $events;

    public function __construct(EventStore $events) {
        $this->events = $events;
    }

    public function handle($c) {
        /** @var ConfirmOrder $c */
        $stream = $this->events->getStream($c->orderId());
        $order = Order::buildFrom($stream->toDomainEvents());
        $order->confirm(
            $c->employeeId(),
            $c->confirmedAt()
        );
        $this->events->storeStream($order->flushEvents());
    }
}
