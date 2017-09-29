<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OrderFulfillment\CommandDispatch\CommandBus;
use OrderFulfillment\OrderProcessing\OrderStatus;

class ConfirmOrder extends Controller {

    /** @var CommandBus */
    private $command;

    public function __construct(CommandBus $command) {
        $this->command = $command;
    }

    public function selectOrderToConfirm() {
        return view('confirm-an-order.select-order-to-confirm', [
            'orders' => OrderStatus::placed()
        ]);
    }

    public function confirmOrder(Request $request) {
        $this->command->execute(
            new \OrderFulfillment\OrderProcessing\ConfirmOrder(
                $request->get('orderId'),
                \Session::get('employee_id'),
                new \DateTimeImmutable('now')
            )
        );
        return \Redirect::to('/confirm-an-order/order-was-confirmed');
    }

    public function thanks() {
        return view('thanks');
    }
}