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

    public function confirmOrder(Request $request, $orderId) {
        $this->command->execute(
            new \OrderFulfillment\OrderProcessing\ConfirmOrder(
                $orderId,
                \Session::get('employee_id'),
                new \DateTimeImmutable('now')
            )
        );
        return \Redirect::to('/confirm-an-order/order-was-confirmed');
    }

    public function orderWasConfirmed() {
        return view('confirm-an-order.order-was-confirmed');
    }
}