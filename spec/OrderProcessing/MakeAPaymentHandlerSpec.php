<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\StreamEvent;
use OrderFulfillment\EventSourcing\StreamEvents;
use OrderFulfillment\EventSourcing\StreamId;
use OrderFulfillment\EventSourcing\StreamVersion;
use OrderFulfillment\OrderProcessing\ConfirmOrder;
use OrderFulfillment\OrderProcessing\ConfirmOrderHandler;
use OrderFulfillment\OrderProcessing\MakeAPayment;
use OrderFulfillment\OrderProcessing\OrderWasPlaced;
use PhpSpec\ObjectBehavior;
use spec\OrderFulfillment\EventSourcing\TestEventStoreSpy;
use function spec\OrderFulfillment\PhpSpec\expect;

class MakeAPaymentHandlerSpec extends ObjectBehavior {

    private $eventStore;
    private $eventCount;

    function let() {
        $builder = new OrderStreamBuilder();

        $this->eventStore = new TestEventStoreSpy;
        $this->beConstructedWith($this->eventStore);
        $this->eventStore->storeStream($builder->placeOrder('order id'));
        $this->eventCount = $this->eventStore->storedEvents()->count();
    }

    function it_coordinates_order_payment() {
        $this->handle(new MakeAPayment(
            'order id',
            '100', 'USD',
            new \DateTimeImmutable('2017-07-27 9:10:11')
        ));
        expect($this->eventStore->storedEvents()->count())
            ->toNotBe($this->eventCount);
    }
}
