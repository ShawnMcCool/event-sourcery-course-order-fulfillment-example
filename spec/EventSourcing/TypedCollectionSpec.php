<?php namespace spec\OrderFulfillment\EventSourcing;

use OrderFulfillment\EventSourcing\Collection;
use OrderFulfillment\EventSourcing\DomainEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OrderFulfillment\EventSourcing\TypedCollection;

class TypedCollectionSpec extends ObjectBehavior {

    function let() {
        $this->beAnInstanceOf(TestTypedCollection::class);
        $this->beConstructedThrough('make', [[
            new TestDomainEvent(),
            new TestDomainEvent()
        ]]);
    }

    function it_can_be_constructed_with_elements_of_the_correct_type() {
        $this->beConstructedThrough('make', [[
            new TestDomainEvent(),
            new TestDomainEvent()
        ]]);
        $this->shouldHaveType(TestTypedCollection::class);
    }

    function it_cannot_be_constructed_with_elements_of_another_type() {
        $this->beConstructedThrough('make', [[
            new TestDomainEvent(),
            new \stdClass(),
        ]]);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_can_add_a_value_of_the_correct_type() {
        $this->add(new TestDomainEvent())->count()
            ->shouldBe(3);
        $this->add(new TestDomainEvent())->count()
            ->shouldBe(3);
    }

    function it_cannot_add_a_value_of_another_type() {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('add', [new \stdClass()]);
    }

    function it_can_map_to_a_typed_collection() {
        $this->map(function($i) { return $i; })
            ->shouldHaveType(TestTypedCollection::class);
    }

    function it_can_fall_back_to_generic_collections_when_mapping_to_other_types() {
        $this->map(function($i) { return 1; })
            ->shouldHaveType(Collection::class);
    }
}

class TestTypedCollection extends TypedCollection {
    protected $collectionType = DomainEvent::class;
}