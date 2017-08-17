<?php namespace OrderFulfillment\LaravelEventSourcingDrivers;

use DB;
use Illuminate\Support\Collection;
use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\DomainEvents;
use OrderFulfillment\EventSourcing\DomainEventSerializer;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\StreamEvents;
use OrderFulfillment\EventSourcing\StreamId;
use OrderFulfillment\EventSourcing\StreamVersion;

class RelationalEventStore implements EventStore {

    /** @var DomainEventSerializer */
    private $serializer;

    private $table = 'event_store';

    public function __construct(DomainEventSerializer $serializer) {
        $this->serializer = $serializer;
    }

    public function allFor(StreamId $id): DomainEvents {
        return DomainEvents::make(
            $this->eventDataFor($id)
                ->map('buildEventFromPayload')
                ->toArray());
    }

    private function eventDataFor(StreamId $id): Collection {
        return DB::table($this->table)
            ->where('stream_id', '=', $id->toString())
            ->orderBy('stream_version', 'asc')
            ->get();
    }

    public function storeStream(StreamEvents $events): void {
        // store events
        $events->each(function ($stream) {
            $this->store($stream->id(), $stream->event(), $stream->version());
        });
        // queue event dispatch
        $job = new DispatchDomainEvents($events->toDomainEvents());
        dispatch($job->onQueue('event_dispatch'));
    }

    public function storeEvent(DomainEvent $event): void {
        $this->store(
            StreamId::fromString(0),
            $event,
            StreamVersion::zero(),
            ''
        );
        $job = new DispatchDomainEvents(DomainEvents::make($event));
        dispatch($job->onQueue('event_dispatch'));
    }

    private function store(StreamId $id, DomainEvent $event, StreamVersion $version, $metadata = ''): void {
        DB::table($this->table)->insert([
            'stream_id'      => $id->toString(),
            'stream_version' => $version->toInt(),
            'event_name'     => $this->serializer->eventNameForClass(get_class($event)),
            'event_data'     => $this->serializer->serialize($event),
            'raised_at'      => date('Y-m-d H:i:s'),
            'meta_data'      => $metadata,
        ]);
    }
}
