<?php namespace OrderFulfillment\LatePaymentReminders;

use Illuminate\Support\ServiceProvider;
use OrderFulfillment\EventSourcing\DomainEventClassMap;
use OrderFulfillment\EventSourcing\EventDispatcher;

class LatePaymentRemindersServiceProvider extends ServiceProvider {

    public function boot() {
        /** @var DomainEventClassMap $eventClasses */
        $eventClasses = $this->app[DomainEventClassMap::class];
//        $eventClasses->add('OrderWasPlaced', OrderWasPlaced::class);

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->app[EventDispatcher::class];
        $dispatcher->addListener(new IdentifyOverdueInvoices());
    }
}