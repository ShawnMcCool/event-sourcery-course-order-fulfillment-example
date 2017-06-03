<?php namespace OrderFulfillment\LaravelEventSourcingDrivers;

use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;
use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\Projection;

abstract class RelationalProjection implements Projection {

    /** @var EventStore $events */
    protected $events;

    public function __construct(EventStore $events) {
        $this->events = $events;
    }

    abstract public function name() : string;

    abstract public function tableName(): string;

    private function getShortName($class) : string {
        $className = explode('\\', get_class($class));
        return $className[count($className) - 1];
    }

    public function handle(DomainEvent $event) : void {
        $method = lcfirst($this->getShortName($event));
        if (method_exists($this, $method)) {
            $this->$method($event);
        }
    }

    protected function table() : Builder {
        return \DB::table($this->tableName());
    }

    abstract public function reset() : void;
}
