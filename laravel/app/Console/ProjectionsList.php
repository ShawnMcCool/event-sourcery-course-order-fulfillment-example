<?php namespace App\Console;

use Illuminate\Console\Command;
use OrderFulfillment\EventSourcing\ProjectionManager;

class ProjectionsList extends Command {

    protected $signature = 'projections:list';
    protected $description = 'List projections.';

    private $projections;

    public function __construct(ProjectionManager $projections) {
        parent::__construct();
        $this->projections = $projections;
    }

    public function handle() {
        $projections = $this->projections->list()->toArray();

        $this->table(
            ['Projections'],
            array_map(function($projection) {
                return [$projection];
            }, $projections)
        );
    }
}
