<?php namespace OrderFulfillment\EventSourcing;

class DomainEventClassMap {

    private $eventClasses;

    public function add($event, $class) : void {
        $this->eventClasses[$event] = $class;
    }

    public function classFor($event) : string {
        if ( ! isset($this->eventClasses[$event])) {
            throw new \InvalidArgumentException("Could not find a class for the event {$event}.");
        }
        return $this->eventClasses[$event];
    }
}
