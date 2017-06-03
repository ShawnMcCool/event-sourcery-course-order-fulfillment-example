<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\DomainEventClassMap;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DomainEventClassMapSpec extends ObjectBehavior {

    function it_is_initializable() {
        $this->shouldHaveType(DomainEventClassMap::class);
    }

    function it_can_translate_event_names_to_class_names() {
        $this->add('eventname', 'classname');
        $this->classFor('eventname')->shouldBe('classname');
    }
}
