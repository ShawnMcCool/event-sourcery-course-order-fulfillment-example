<?php namespace OrderFulfillment\LaravelEventSourcingDrivers;

use Illuminate\Support\ServiceProvider;
use OrderFulfillment\EventSourcing\AggregateRepository;
use OrderFulfillment\EventSourcing\DomainEventClassMap;
use OrderFulfillment\EventSourcing\DomainEventSerializer;
use OrderFulfillment\EventSourcing\EventDispatcher;
use OrderFulfillment\EventSourcing\EventSourcedAggregateRepository;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\ImmediateEventDispatcher;
use OrderFulfillment\EventSourcing\LogDomainEvents;
use OrderFulfillment\EventSourcing\ProjectionManager;
use OrderFulfillment\EventSourcing\Projections;

/**
 * Bootstraps the Event Sourcing infrastructure in a Laravel application.
 */
final class EventSourcingServiceProvider extends ServiceProvider {

    public function register() {
        // return the same instance every time the service
        // container is asked to resolve a dispatcher
        $this->app->singleton(EventDispatcher::class, function ($app) {
            return new ImmediateEventDispatcher;
        });

        // return the same instance every time the service
        // container is asked to resolve the class map
        $this->app->singleton(DomainEventClassMap::class, function ($app) {
            return new DomainEventClassMap;
        });

        // return an instance of the framework / application's
        // preferred event store every time the server container
        // is asked to return an instance of the EventStore interface
        $this->app->bind(EventStore::class, function ($app) {
            return new RelationalEventStore($app[DomainEventSerializer::class]);
        });

        // return the same projection manager every time the
        // service container is asked to resolve one
        $this->app->singleton(ProjectionManager::class, function ($app) {
            return new ProjectionManager(Projections::make([]));
        });
    }

    public function boot() {
        // The projection manager is an event listener, so it
        // must be added to the event dispatcher.
        $dispatcher = $this->app[EventDispatcher::class];
        $dispatcher->addListener($this->app[ProjectionManager::class]);
        $dispatcher->addListener($this->app[LogDomainEvents::class]);
    }
}
