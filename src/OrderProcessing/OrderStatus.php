<?php namespace OrderFulfillment\OrderProcessing;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model {
    protected $table = 'order_processing_order_status';
    protected $dates = ['order_placed_at'];

    public static function placed() {
        return static::where('order_status', '=', 'placed')->orderBy('order_placed_at', 'asc')->get();
    }

    public function productArray() {
        return (array) json_decode($this->product_list_json);
    }

    public function delimitedProductList($delimiter = ', ') {
        return implode($delimiter, $this->productArray());
    }

    public function totalPriceWithCurrency() {
        return $this->order_currency . ' ' . number_format(($this->total_price / 100), 2);
    }

    public function placedAt() {
        return $this->order_placed_at->toDateTimeString();
    }
}