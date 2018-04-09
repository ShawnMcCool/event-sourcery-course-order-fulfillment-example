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
            $t->dateTime('became_late_at');
            $t->dateTime('became_extremely_late_at');
        });
    }

    public function down() {
        Schema::drop('late_payment_reminders_orders_with_overdue_payments_list');
    }
}
