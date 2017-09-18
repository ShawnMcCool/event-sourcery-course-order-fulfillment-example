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

    public function viewPlacedOrders() {
        return view('confirm-order', [
            'orders' => OrderStatus::placed()
        ]);
    }

    public function place(Request $request) {
        $this->command->execute(
            new \OrderFulfillment\OrderProcessing\PlaceOrder(
                OrderId::generate(),
                \Session::get('customer_id'),
                \Session::get('customer_name'),
                $request->get('products'),
                1200,
                'EUR',
                new \DateTimeImmutable('now')
            )
        );
        return \Redirect::to('/thanks-for-your-order');
    }

    public function thanks() {
        return view('thanks');
    }
}