<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProcessingPaymentListTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('order_processing_payment_list', function (Blueprint $t) {
            $t->create();
            $t->increments('id');
            $t->string('order_id');
            $t->string('payment_amount');
            $t->string('payment_currency');
            $t->dateTime('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('order_processing_payment_list');
    }
}
