<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLatePaymentRemindersOrdersWithOverduePaymentsListTable extends Migration {

    public function up() {
        Schema::table('late_payment_reminders_orders_with_overdue_payments_list', function (Blueprint $t) {
            $t->create();
            $t->increments('id');
            $t->string('order_id');
            $t->dateTime('ordered_at');
            $t->boolean('is_overdue')->default(0);
            $t->dateTime('became_overdue_at')->nullable();
            $t->boolean('is_extremely_overdue')->default(0);
            $t->dateTime('became_extremely_overdue_at')->nullable();
        });
    }

    public function down() {
        Schema::drop('late_payment_reminders_orders_with_overdue_payments_list');
    }
}
