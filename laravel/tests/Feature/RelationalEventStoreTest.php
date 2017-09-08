<?php namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use OrderFulfillment\EventSourcing\DomainEventClassMap;
use OrderFulfillment\EventSourcing\StreamEvent;
use OrderFulfillment\EventSourcing\StreamEvents;
use OrderFulfillment\EventSourcing\StreamId;
use OrderFulfillment\EventSourcing\StreamVersion;
use OrderFulfillment\LaravelEventSourcingDrivers\RelationalEventStore;
use spec\OrderFulfillment\EventSourcing\TestDomainEvent;
use Tests\TestCase;

class RelationalEventStoreTest extends TestCase {

    use DatabaseMigrations;

    /** @var RelationalEventStore */
    private $store;

    public function setUp() {
        parent::setUp();

        // add our test domain event to the class map
        $this->app[DomainEventClassMap::class]->add('TestDomainEvent', TestDomainEvent::class);
        // resolve the event store
        $this->store = $this->app[RelationalEventStore::class];
    }

    public function testCanStoreAndRetrieveOneDomainEvent() {

        // store test event
        $random = rand(1, 99999);
        $this->store->storeEvent(new TestDomainEvent($random));

        // verify that test event is retrieved
        $events = $this->store->getEvents(1);

        $this->assertTrue($events->first()->number() == $random);
    }

    public function testCanStoreAndRetrieveOneStreamEvent() {

        // store test event
        $random = rand(1, 99999);

        $this->store->storeStream(
            StreamEvents::make([
                new StreamEvent(
                    StreamId::fromString('123'),
                    StreamVersion::zero(),
                    new TestDomainEvent($random)
                ),
            ])
        );

        // verify that test event is retrieved
        $streamEvents = $this->store->getStream(StreamId::fromString('123'));

        // the domain event should be the same
        $this->assertTrue($streamEvents->first()->event()->number() == $random);
    }

    public function testCanStoreAndRetrieveManyStreamEvents() {

        $numberOfEvents = rand(1, 30);
        $randoms = [];
        $events = [];

        foreach (range(1, $numberOfEvents) as $i) {
            $random = rand(1, 9999);
            $randoms[] = $random;
            $events[] = new StreamEvent(
                StreamId::fromString('321'),
                StreamVersion::fromInt($i-1),
                new TestDomainEvent($random)
            );
        }

        // store test event
        $this->store->storeStream(
            StreamEvents::make($events)
        );

        // verify that test event is retrieved
        $streamEvents = $this->store->getStream(StreamId::fromString('321'));

        // the domain event should be the same
        foreach (range(1, $streamEvents->count()) as $i) {
            $this->assertTrue($streamEvents->toArray()[$i-1]->event()->number() == $randoms[$i-1]);
        }
    }

    public function testCanPageThroughEvents() {
        foreach (range(1, 500) as $i) {
            $this->store->storeEvent(new TestDomainEvent($i));
        }

        // takes 20 events, skips 20 events
        $events = $this->store->getEvents(20, 20);

        // should receive 20 events
        $this->assertTrue($events->count() == 20);

        foreach ($events->toArray() as $key => $event) {
            $this->assertTrue($event->number() === $key+21);
        }
    }

    public function testGracefullyReturnsNoEventsWhenPaging() {
        foreach (range(1, 500) as $i) {
            $this->store->storeEvent(new TestDomainEvent($i));
        }

        // takes 20 events, skips 520 events
        $events = $this->store->getEvents(20, 520);

        // should receive zero events
        $this->assertTrue($events->count() == 0);
    }
}