<?php namespace App\Http\Controllers;

use OrderFulfillment\CommandDispatch\CommandBus;
use OrderFulfillment\OrderProcessing\OrderStatus;

class MakePayment extends Controller {

    /** @var CommandBus */
    private $command;

    public function __construct(CommandBus $command) {
        $this->command = $command;
    }

    public function chooseAnOrder() {
        return view('making-a-payment.choose-an-order', [
            'orders' => OrderStatus::confirmed(),
        ]);
    }

}