<?php namespace spec\OrderFulfillment\LaravelCommandDispatchDrivers;

use Illuminate\Contracts\Container\Container;
use OrderFulfillment\CommandDispatch\Command;
use OrderFulfillment\CommandDispatch\ExecutionCommandBus;
use OrderFulfillment\CommandDispatch\CommandHandler;
use OrderFulfillment\CommandDispatch\Mapper;
use OrderFulfillment\LaravelCommandDispatchDrivers\ContainerResolvingExecutionCommandBus;
use PhpSpec\Laravel\LaravelObjectBehavior;

class ContainerResolvingExecutionCommandBusSpec extends LaravelObjectBehavior {

    function let(Container $container) {
        $this->beConstructedWith($container, new Mapper());
    }

    function it_is_initializable() {
        $this->shouldHaveType(ContainerResolvingExecutionCommandBus::class);
    }

    function it_handles_commands(Container $container, TestCommandHandler $handler) {
        $command = new TestCommand;
        $handler->handle($command)->shouldBeCalled();

        $container->make(TestCommandHandler::class)->willReturn($handler);
        $this->beConstructedWith($container, new Mapper());

        $this->execute($command);
    }
}

class TestCommand implements Command {

}

class TestCommandHandler implements CommandHandler {

    public function handle($arg) {
    }
}
