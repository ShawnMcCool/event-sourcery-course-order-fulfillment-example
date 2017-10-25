<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\CommandDispatch\CommandHandler;
use OrderFulfillment\EventSourcing\EventStore;

class MakeAPaymentHandler implements CommandHandler {

    /** @var EventStore */
    private $events;

    public function __construct(EventStore $events) {
        $this->events = $events;
    }

    public function handle($c) {
        /** @var MakeAPayment $c */
        $stream = $this->events->getStream($c->orderId());
        $order = Order::buildFrom($stream->toDomainEvents());
        $order->makePayment(
            $c->amount(),
            $c->paidAt()
        );
        $this->events->storeStream($order->flushEvents());
    }
}
