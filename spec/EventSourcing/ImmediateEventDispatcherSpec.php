<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\DomainEvents;
use OrderFulfillment\EventSourcing\ImmediateEventDispatcher;
use OrderFulfillment\EventSourcing\Listener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImmediateEventDispatcherSpec extends ObjectBehavior {

    function it_is_initializable() {
        $this->shouldHaveType(ImmediateEventDispatcher::class);
    }

    function it_is_extended_through_listeners(Listener $listener) {
        $this->addListener($listener);
    }

    function it_dispatches_a_domain_event(Listener $listener) {
        $event = new TestDomainEvent();

        $this->addListener($listener);
        $listener->handle($event)->shouldBeCalled();
        $this->dispatch(DomainEvents::make([$event]));
    }

    function it_dispatches_domain_events_to_multiple_listeners(Listener $listener) {
        $event = new TestDomainEvent();

        $this->addListener($listener);
        $this->addListener($listener);
        $this->addListener($listener);
        $listener->handle($event)->shouldBeCalledTimes(3);
        $this->dispatch(DomainEvents::make([$event]));
    }
}
