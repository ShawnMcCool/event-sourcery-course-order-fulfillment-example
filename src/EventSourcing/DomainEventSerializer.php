<?php namespace OrderFulfillment\EventSourcing;

class DomainEventSerializer {

    /** @var DomainEventClassMap */
    private $eventClasses;

    public function __construct(DomainEventClassMap $eventClasses) {
        $this->eventClasses = $eventClasses;
    }

    public function serialize(DomainEvent $event): string {
        return json_encode($event->serialize());
    }

    public function deserialize(\stdClass $serializedEvent): DomainEvent {
        $class = $this->eventClasses->classFor($serializedEvent->event_name);
        return $class::deserialize($serializedEvent->event_data);
    }

    public function eventNameFor(DomainEvent $e): string {
        $className = explode('\\', get_class($e));
        return $className[count($className) - 1];
    }
}
