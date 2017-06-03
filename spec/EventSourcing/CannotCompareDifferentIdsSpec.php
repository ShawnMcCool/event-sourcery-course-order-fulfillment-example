<?php namespace spec\OrderFulfillment\EventSourcing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OrderFulfillment\EventSourcing\CannotCompareDifferentIds;

class CannotCompareDifferentIdsSpec extends ObjectBehavior {
    function it_is_initializable() {
        $this->shouldHaveType(CannotCompareDifferentIds::class);
    }
}
