<?php namespace OrderFulfillment\LatePaymentReminders;

use Illuminate\Support\ServiceProvider;
use OrderFulfillment\EventSourcing\DomainEventClassMap;
use OrderFulfillment\EventSourcing\EventDispatcher;
use OrderFulfillment\EventSourcing\EventStore;

class LatePaymentRemindersServiceProvider extends ServiceProvider {

    public function boot() {
        /** @var DomainEventClassMap $eventClasses */
        $eventClasses = $this->app[DomainEventClassMap::class];
        $eventClasses->add('InvoiceBecameOverdue', InvoiceBecameOverdue::class);
        $eventClasses->add('InvoiceBecameExtremelyOverdue', InvoiceBecameExtremelyOverdue::class);
        $eventClasses->add('ADayPassed', ADayPassed::class);

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->app[EventDispatcher::class];
        $eventStore = $this->app[EventStore::class];
        $dispatcher->addListener(new IdentifyOverdueInvoices($eventStore));
    }
}