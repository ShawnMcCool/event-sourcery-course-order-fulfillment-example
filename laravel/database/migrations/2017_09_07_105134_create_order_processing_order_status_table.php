<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProcessingOrderStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_processing_order_status', function(Blueprint $t) {
            $t->create();
            $t->increments('id');
            $t->string('order_id');
            $t->string('customer_id');
            $t->string('customer_name');
            $t->text('product_list_json');
            $t->string('total_price');
            $t->string('order_currency');
            $t->string('order_status');

            $t->dateTime('order_placed_at')->nullable();

            $t->string('confirmed_by_employee_id')->nullable();
            $t->datetime('confirmed_at')->nullable();

            $t->string('total_payment_received');
            $t->datetime('last_payment_received_at')->nullable();
            $t->datetime('completed_at')->nullable();

            $t->string('fulfilled_by_employee_id')->nullable();
            $t->dateTime('fulfilled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_processing_order_status');
    }
}
