<?php namespace OrderFulfillment\OrderProcessing;

use Illuminate\Support\ServiceProvider;
use OrderFulfillment\EventSourcing\DomainEventClassMap;

class OrderProcessingServiceProvider extends ServiceProvider {
    public function boot() {
        $eventClasses = $this->app[DomainEventClassMap::class];
        $eventClasses->add('OrderWasPlaced', OrderWasPlaced::class);
    }
}