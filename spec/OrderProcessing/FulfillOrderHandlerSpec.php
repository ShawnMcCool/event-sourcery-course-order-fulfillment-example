<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\OrderProcessing\FulfillOrder;
use PhpSpec\ObjectBehavior;
use spec\OrderFulfillment\EventSourcing\TestEventStoreSpy;
use function spec\OrderFulfillment\PhpSpec\expect;

class FulfillOrderHandlerSpec extends ObjectBehavior {

    private $eventStore;

    function let() {
        $builder = new OrderStreamBuilder();

        $this->eventStore = new TestEventStoreSpy;
        $this->beConstructedWith($this->eventStore);

        $orderId = 'order id';
        $stream = $builder->placeOrder($orderId);
        $stream = $builder->confirmOrder($stream, $orderId);
        $stream = $builder->completeOrder($stream, $orderId);
        $this->eventStore->storeStream($stream);
    }

    function it_coordinates_order_fulfillment() {
        $this->handle(new FulfillOrder(
            'order id',
            'employee id',
            new \DateTimeImmutable('2017-07-27 9:10:11')
        ));
        expect($this->eventStore->storedEvents()->count())
            ->toNotBe(1);
    }
}
