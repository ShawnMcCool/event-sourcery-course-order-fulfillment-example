<?php namespace OrderFulfillment\LaravelCommandDispatchDrivers;

use Illuminate\Contracts\Container\Container;
use OrderFulfillment\CommandDispatch\Command;
use OrderFulfillment\CommandDispatch\CommandBus;
use OrderFulfillment\CommandDispatch\Mapper;

class ContainerResolvingExecutionCommandBus implements CommandBus {

    /** @var Container */
    private $container;
    /** @var Mapper */
    private $mapper;

    public function __construct(Container $container, Mapper $mapper) {
        $this->container = $container;
        $this->mapper = $mapper;
    }

    public function execute(Command $c) {
        $this->container->make($this->mapper->handlerFor($c))->handle($c);
    }
}
