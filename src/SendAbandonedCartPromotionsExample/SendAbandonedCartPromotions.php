<?php namespace OrderFulfillment\SendAbandonedCartPromotionsExample;

use OrderFulfillment\CommandDispatch\CommandBus;
use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\Listener;

class SendAbandonedCartPromotions implements Listener {

    /** @var EventStore */
    private $events;
    /** @var CommandBus */
    private $bus;

    public function __construct(EventStore $events, CommandBus $bus) {
        $this->events = $events;
        $this->bus = $bus;
    }

    public function handle(DomainEvent $event): void {
        if ($event instanceof ProductWasAddedToCart) {
            $this->addProductToCart($event);
        } elseif ($event instanceof CheckoutWasCompleted) {
            $this->stopMonitoringCart($event->cartId());
        } elseif ($event instanceof HourHasPassed) {
            $this->identifyAbandonedCarts($event);
        }
    }

    private function addProductToCart(ProductWasAddedToCart $event) {
        // insert into cart_products (...) values (...);
    }

    private function stopMonitoringCart(CartId $cartId) {
        // delete from cart_products where cart_id = $cartId;
   }

    private function identifyAbandonedCarts(HourHasPassed $event) {
        $cartIds = query('select * from cart_products where ...');

        foreach ($cartIds as $cartId) {
            $this->bus->execute(new SendAbandonedCartPromo($cartId, $event->timestamp()));
            $this->stopMonitoringCart($cartId);
        }
    }
}