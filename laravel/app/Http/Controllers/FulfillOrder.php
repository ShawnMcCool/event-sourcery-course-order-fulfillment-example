<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OrderFulfillment\CommandDispatch\CommandBus;
use OrderFulfillment\OrderProcessing\OrderStatus;

class FulfillOrder extends Controller {

    /** @var CommandBus */
    private $command;

    public function __construct(CommandBus $command) {
        $this->command = $command;
    }

    public function selectOrderToFulfill() {
        return view('fulfill-an-order.select-order-to-fulfill', [
            'orders' => OrderStatus::completed()
        ]);
    }

    public function fulfillOrder(Request $request, $orderId) {
        $this->command->execute(
            new \OrderFulfillment\OrderProcessing\FulfillOrder(
                $orderId,
                \Session::get('employee_id'),
                new \DateTimeImmutable('now')
            )
        );
        return \Redirect::to('/fulfill-an-order/order-was-fulfilled');
    }

    public function orderWasFulfilled() {
        return view('fulfill-an-order.order-was-fulfilled');
    }
}