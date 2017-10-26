<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\LaravelEventSourcingDrivers\RelationalProjection;

class PaymentListProjection extends RelationalProjection {

    public function name(): string {
        return 'order_processing-payment_list';
    }

    public function tableName(): string {
        return 'order_processing_payment_list';
    }

    public function reset(): void {
        $this->table()->truncate();
    }

    public function PaymentWasMade(PaymentWasMade $e): void {
        $this->table()->insert([
            'order_id' => $e->orderId()->toString(),
            'payment_amount' => $e->amount()->toCents(),
            'payment_currency' => $e->amount()->currency()->toString(),
            'paid_at' => $e->paidAt()->format('Y-m-d H:i:s')
        ]);
    }
}