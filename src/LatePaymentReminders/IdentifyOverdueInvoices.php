<?php namespace OrderFulfillment\LatePaymentReminders;

use Illuminate\Database\Query\Builder;
use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\EventStore;
use OrderFulfillment\EventSourcing\Listener;
use OrderFulfillment\OrderProcessing\InvoiceWasSent;
use OrderFulfillment\OrderProcessing\OrderId;

class IdentifyOverdueInvoices implements Listener {

    /** @var EventStore */
    private $events;

    public function __construct(EventStore $events) {
        $this->events = $events;
    }

    public function handle(DomainEvent $event): void {
        if ($event instanceof InvoiceWasSent) {
            $this->beginTrackingNewOrder($event);
        } elseif ($event instanceof ADayPassed) {
            $this->markExtremelyOverdueOrders($event);
            $this->markOverdueOrders($event);
        }
    }

    private function beginTrackingNewOrder(InvoiceWasSent $e) {
        $this->table()->insert([
            'order_id'             => $e->orderId()->toString(),
            'ordered_at'           => $e->sentAt()->format('Y-m-d H:i:s'),
            'is_overdue'           => false,
            'is_extremely_overdue' => false,
        ]);
    }

    private function markExtremelyOverdueOrders(ADayPassed $e) {
        $orders = $this->table()->where('ordered_at', '>', \DB::raw('interval now - 60 days'))
            ->where('is_extremely_overdue', '=', false)
            ->get();

        if ( ! $orders) return;

        $orders->each(function ($order) {
            $this->table()->where('order_id', '=', $order->order_id)->update([
                'is_overdue'                  => true,
                'is_extremely_overdue'        => true,
                'became_extremely_overdue_at' => (new \DateTimeImmutable('now'))->format('Y-m-d H:i:s'),
            ]);

            $this->events->storeEvent(new InvoiceBecameExtremelyOverdue(
                OrderId::fromString($order->order_id),
                new \DateTimeImmutable($order->became_extremely_overdue_at)
            ));
        });
    }

    private function markOverdueOrders(ADayPassed $event) {
        $orders = $this->table()->where('ordered_at', '>', \DB::raw('interval now - 30 days'))
            ->where('is_overdue', '=', false)
            ->where('is_extremely_overdue', '=', false)
            ->get();

        if ( ! $orders) return;

        $orders->each(function ($order) {
            $this->table()->where('order_id', '=', $order->order_id)->update([
                'is_overdue'        => true,
                'became_overdue_at' => (new \DateTimeImmutable('now'))->format('Y-m-d H:i:s'),
            ]);

            $this->events->storeEvent(new InvoiceBecameOverdue(
                OrderId::fromString($order->order_id),
                new \DateTimeImmutable($order->became_extremely_overdue_at)
            ));
        });
    }

    private function table(): Builder {
        return \DB::table('late_payment_reminders_orders_with_overdue_payments_list');
    }
}