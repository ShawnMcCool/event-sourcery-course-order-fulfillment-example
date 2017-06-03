<?php namespace OrderFulfillment\EventSourcing;

interface Projection extends Listener {

    public function name() : string;

    public function reset() : void;
}