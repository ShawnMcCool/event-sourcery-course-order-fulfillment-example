<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\LaravelEventSourcingDrivers\RelationalProjection;

class OrderStatusProjection extends RelationalProjection {

    public function name(): string {
        return 'order_processing-order_status';
    }

    public function tableName(): string {
        return 'order_processing_order_status';
    }

    public function reset(): void {
        $this->table()->truncate();
    }

    public function OrderWasPlaced(OrderWasPlaced $e): void {
        $productIds = array_map(function(ProductId $productId) {
            return $productId->toString();
        }, $e->products());

        $this->table()->insert([
            'order_id' => $e->orderId()->toString(),
            'customer_id' => $e->customerId()->toString(),
            'customer_name' => $e->customerName(),
            'product_list_json' => json_encode($productIds),
            'total_price' => $e->totalPrice()->toCents(),
            'order_currency' => $e->totalPrice()->currency()->toString(),
            'order_status' => 'placed',
            'total_payment_received' => '0',
            'order_placed_at' => $e->placedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function OrderWasConfirmed(OrderWasConfirmed $e): void {
        $this->table()->where('order_id', '=', $e->orderId()->toString())->update([
            'order_status' => 'confirmed',
            'confirmed_by_employee_id' => $e->employeeId()->toString(),
            'confirmed_at' => $e->confirmedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function PaymentWasMade(PaymentWasMade $e): void {
        $this->table()->where('order_id', '=', $e->orderId()->toString())->increment('total_payment_received', $e->amount()->toCents());
        $this->table()->where('order_id', '=', $e->orderId()->toString())->update([
            'last_payment_received_at' => $e->paidAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function OrderWasCompleted(OrderWasCompleted $e): void {
        $this->table()->where('order_id', '=', $e->orderId()->toString())->update([
            'order_status' => 'completed',
            'completed_at' => $e->completedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function OrderWasFulfilled(OrderWasFulfilled $e): void {
        $this->table()->where('order_id', '=', $e->orderId()->toString())->update([
            'order_status' => 'fulfilled',
            'fulfilled_by_employee_id' => $e->employeeId()->toString(),
            'fulfilled_at' => $e->fulfilledAt()->format('Y-m-d H:i:s')
        ]);
    }
}