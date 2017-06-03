<?php namespace OrderFulfillment\CommandDispatch;

interface CommandBus {
    public function execute(Command $c);
}
