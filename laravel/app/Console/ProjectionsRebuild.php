<?php namespace App\Console;

use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\ProjectionManager;
use Illuminate\Console\Command;
use OrderFulfillment\LaravelEventSourcingDrivers\RelationalProjection;

class ProjectionsRebuild extends Command {

    protected $signature = 'projections:rebuild {projection}';
    protected $description = 'Reset and run ALL domain events through one projection.';

    /** @var EventStore */
    private $events;
    /** @var ProjectionManager */
    private $projections;

    public function __construct(EventStore $events, ProjectionManager $projections) {
        parent::__construct();
        $this->events      = $events;
        $this->projections = $projections;
    }

    public function handle() {
        /** @var RelationalEventHandler $projection */
        $projection = $this->projections->all()->filter(function(RelationalProjection $projection) {
            return $projection->name() == $this->argument('projection');
        })->first();

        $projection->reset();

        $chunk = 0;
        $events = $this->events->getEvents(100, $chunk*100);
        while ($events->count() > 0) {
            foreach ($events as $event) {
                $projection->handle($event);
            }
            $chunk++;
            $events = $this->events->getEvents(100, $chunk*100);
        }
    }
}
