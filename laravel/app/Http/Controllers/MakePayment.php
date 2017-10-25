<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OrderFulfillment\CommandDispatch\CommandBus;
use OrderFulfillment\OrderProcessing\MakeAPayment;
use OrderFulfillment\OrderProcessing\OrderStatus;
use OrderFulfillment\OrderProcessing\PaymentList;

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
            'payments' => PaymentList::paymentsForOrder($orderId)
        ]);
    }

    public function makeAPayment($orderId, Request $request) {
        $this->command->execute(
            new MakeAPayment($orderId, $request->get('payment_amount') * 100, 'EUR', new \DateTimeImmutable)
        );
        return \Redirect::to('/make-a-payment/payment-was-made');
    }

    public function paymentWasMade() {
        return view('making-a-payment/payment-was-made');
    }
}