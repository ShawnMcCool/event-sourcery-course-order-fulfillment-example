<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OrderFulfillment\CommandDispatch\CommandBus;
use OrderFulfillment\OrderProcessing\OrderId;

class PlaceOrder extends Controller {

    /** @var CommandBus */
    private $command;

    public function __construct(CommandBus $command) {
        $this->command = $command;
    }

    public function viewProducts() {
        return view('place-an-order.view-products');
    }

    public function placeOrder(Request $request) {
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
        return \Redirect::to('/place-an-order/thanks-for-your-order');
    }

    public function thanksForYourOrder() {
        return view('place-an-order/thanks-for-your-order');
    }
}