<?php namespace OrderFulfillment\LatePaymentReminders;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\EventSourcing\Listener;

class IdentifyOverdueInvoices implements Listener {

    public function handle(DomainEvent $event): void {

    }
}

//class IdentifyOverdueInvoices extends RelationalEventHandler {
//
//    /** @var EventStore */
//    private $eventStore;
//
//    public function __construct(EventStore $eventStore) {
//        $this->eventStore = $eventStore;
//    }
//
//    public function tableName() {
//        return 'payment_reminders_identify_overdue_invoices';
//    }
//
//    public function reset() {
//        $this->table()->truncate();
//    }
//
//    public function TitoRegistrationWasFinished(TitoRegistrationWasFinished $e) {
//        if ($e->paymentProvider() != 'Invoice') return;
//
//        $this->table()->insert([
//            'invoiceId' => $e->registrationId(),
//            'sentAt' => (new \DateTimeImmutable($e->finishedAt()))->format('Y-m-d H:i:s'),
//            'status' => 'unpaid'
//        ]);
//    }
//
//    public function TitoRegistrationWasMarkedAsPaid(TitoRegistrationWasMarkedAsPaid $e) {
//        $this->table()->where('invoiceId', '=', $e->registrationId())->delete();
//    }
//}