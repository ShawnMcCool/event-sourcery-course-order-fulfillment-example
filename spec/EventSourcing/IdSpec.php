<?php namespace spec\OrderFulfillment\EventSourcing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use function spec\OrderFulfillment\PhpSpec\expect;
use OrderFulfillment\EventSourcing\CannotCompareDifferentIds;

class IdSpec extends ObjectBehavior {

    function let() {
        $this->beAnInstanceOf(TestId::class);
        $this->beConstructedThrough('fromString', ['anId']);
    }

    function it_contains_an_id_string() {
        $this->toString()->shouldReturn('anId');
    }

    function it_can_be_cast_to_string() {
        expect((string) $this->getWrappedObject())->toBe('anId');
    }

    function it_throws_if_its_not_a_string() {
        $this->beConstructedThrough('fromString', [123]);
        $this->shouldThrow(\InvalidArgumentException::class)
            ->duringInstantiation();
    }

    function it_compares_ids_by_value() {
        $this->shouldEqualValue(TestId::fromString('anId'));
    }

    function it_compares_ids_of_the_same_type_only() {
        $this->shouldThrow(CannotCompareDifferentIds::class)
            ->during('equals', [TestIdTwo::fromString('anId')]);
    }

}