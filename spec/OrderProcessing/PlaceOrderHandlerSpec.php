<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\PlaceOrder;
use PhpSpec\ObjectBehavior;
use spec\OrderFulfillment\EventSourcing\TestEventStoreSpy;
use function spec\OrderFulfillment\PhpSpec\expect;

class PlaceOrderHandlerSpec extends ObjectBehavior {

    private $eventStore;

    function let() {
        $this->eventStore = new TestEventStoreSpy;
        $this->beConstructedWith($this->eventStore);
    }

    function it_coordinates_order_placement() {
        $this->handle(new PlaceOrder(
            'order id',
            'customer id',
            'customer name',
            ['product 1', 'product 2'],
            '1200',
            'EUR',
            new \DateTimeImmutable('2017-07-27 9:10:11')
        ));
        expect($this->eventStore->storedEvents()->count())
            ->toNotBe(0);
    }
}
