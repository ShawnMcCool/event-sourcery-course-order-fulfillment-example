<?php namespace OrderFulfillment\CommandDispatch;

interface CommandHandler {
    public function handle($command);
}
