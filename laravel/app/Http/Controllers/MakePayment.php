<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function makeAPaymentForm($orderId) {
        return view('making-a-payment/make-a-payment', [
            'order' => OrderStatus::where('order_id', '=', $orderId)->firstOrFail(),
            'payments' => collect([])
        ]);
    }

    public function makeAPayment($orderId, Request $request) {
        $this->command->execute(

        );
    }
}