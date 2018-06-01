<?php namespace OrderFulfillment\OrderProcessing;

use Illuminate\Support\ServiceProvider;
use OrderFulfillment\EventSourcing\DomainEventClassMap;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\ProjectionManager;

class OrderProcessingServiceProvider extends ServiceProvider {

    public function boot() {
        /** @var DomainEventClassMap $eventClasses */
        $eventClasses = $this->app[DomainEventClassMap::class];
        // map the 'OrderWasPlaced' event to the correct class.
        $eventClasses->add('OrderWasPlaced', OrderWasPlaced::class);
        $eventClasses->add('OrderWasConfirmed', OrderWasConfirmed::class);
        $eventClasses->add('PaymentWasMade', PaymentWasMade::class);
        $eventClasses->add('OrderWasCompleted', OrderWasCompleted::class);
        $eventClasses->add('OrderWasFulfilled', OrderWasFulfilled::class);
        $eventClasses->add('InvoiceWasSent', InvoiceWasSent::class);

        /** @var ProjectionManager $projections */
        $projections = $this->app[ProjectionManager::class];
        // instantiate and add projection listener to the projection manager
        $projections->add(new OrderStatusProjection($this->app[EventStore::class]));
        $projections->add(new PaymentListProjection($this->app[EventStore::class]));
    }
}