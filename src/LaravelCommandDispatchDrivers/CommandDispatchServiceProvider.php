<?php namespace OrderFulfillment\LaravelCommandDispatchDrivers;

use Illuminate\Support\ServiceProvider;
use OrderFulfillment\CommandDispatch\CommandBus;

class CommandDispatchServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind(CommandBus::class, ContainerResolvingExecutionCommandBus::class);
    }
}
