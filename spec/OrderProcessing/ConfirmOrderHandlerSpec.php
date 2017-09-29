<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\StreamEvent;
use OrderFulfillment\EventSourcing\StreamEvents;
use OrderFulfillment\EventSourcing\StreamId;
use OrderFulfillment\EventSourcing\StreamVersion;
use OrderFulfillment\OrderProcessing\ConfirmOrder;
use OrderFulfillment\OrderProcessing\ConfirmOrderHandler;
use OrderFulfillment\OrderProcessing\OrderWasPlaced;
use PhpSpec\ObjectBehavior;
use spec\OrderFulfillment\EventSourcing\TestEventStoreSpy;
use function spec\OrderFulfillment\PhpSpec\expect;

class ConfirmOrderHandlerSpec extends ObjectBehavior {

    private $eventStore;

    function let() {
        $builder = new OrderStreamBuilder();

        $this->eventStore = new TestEventStoreSpy;
        $this->beConstructedWith($this->eventStore);
        $this->eventStore->storeStream($builder->placeOrder('order id'));
    }

    function it_coordinates_order_confirmation() {
        $this->handle(new ConfirmOrder(
            'order id',
            'employee id',
            new \DateTimeImmutable('2017-07-27 9:10:11')
        ));
        expect($this->eventStore->storedEvents()->count())
            ->toNotBe(1);
    }
}
