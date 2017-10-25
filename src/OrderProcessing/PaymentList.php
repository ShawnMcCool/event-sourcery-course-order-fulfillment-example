<?php namespace OrderFulfillment\OrderProcessing;

use Illuminate\Database\Eloquent\Model;

class PaymentList extends Model {
    protected $table = 'order_processing_payment_list';
    protected $dates = ['paid_at'];

    public static function paymentsForOrder($orderId) {
        return static::where('order_id', '=', $orderId)->orderBy('paid_at', 'asc')->get();
    }

    public function orderId() {
        return $this->order_id;
    }

    public function amountWithCurrency() {
        return $this->payment_currency . ' ' . number_format(($this->payment_amount / 100), 2);
    }

    public function paidAt() {
        return $this->paid_at->toDateTimeString();
    }
}