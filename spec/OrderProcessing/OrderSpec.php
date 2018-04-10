<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\CannotConfirmOrderMoreThanOnce;
use OrderFulfillment\OrderProcessing\CannotFulfillAnOrderThatHasNotBeenCompleted;
use OrderFulfillment\OrderProcessing\CannotMakePaymentsOnUnconfirmedOrders;
use OrderFulfillment\OrderProcessing\CannotPayMoreThanTotal;
use OrderFulfillment\OrderProcessing\CustomerId;
use OrderFulfillment\OrderProcessing\EmployeeId;
use OrderFulfillment\OrderProcessing\InvoiceWasSent;
use OrderFulfillment\OrderProcessing\OrderId;
use OrderFulfillment\OrderProcessing\OrderWasCompleted;
use OrderFulfillment\OrderProcessing\OrderWasConfirmed;
use OrderFulfillment\OrderProcessing\OrderWasFulfilled;
use OrderFulfillment\OrderProcessing\OrderWasPlaced;
use OrderFulfillment\OrderProcessing\PaymentWasMade;
use OrderFulfillment\OrderProcessing\ProductId;
use PhpSpec\ObjectBehavior;

class OrderSpec extends ObjectBehavior {

    private $orderId = 'group id';
    private $customerId = 'customer id';
    private $customerName = 'customer name';
    private $products = ['product id 1', 'product id 2'];
    private $totalPriceCents = '1200';
    private $currency = 'usd';
    private $placedAt = '2017-01-01 23:21:23';

    private $employeeId = 'employee id';
    private $confirmedAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedThrough('place', [
            OrderId::fromString($this->orderId),
            CustomerId::fromString($this->customerId),
            $this->customerName,
            array_map(function($productId) {
                return ProductId::fromString($productId);
            }, $this->products),
            Money::fromCents($this->totalPriceCents, new Currency($this->currency)),
            new \DateTimeImmutable($this->placedAt)
        ]);
    }

    function it_places_orders() {
        $this->flushEvents()->shouldContainEvent(
            new OrderWasPlaced(
                OrderId::fromString($this->orderId),
                CustomerId::fromString($this->customerId),
                $this->customerName,
                array_map(function($productId) {
                    return ProductId::fromString($productId);
                }, $this->products),
                Money::fromCents($this->totalPriceCents, new Currency($this->currency)),
                new \DateTimeImmutable($this->placedAt)
            )
        );
    }

    function it_confirms_orders() {
        $this->confirm(
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );

        $this->flushEvents()->shouldContainEvent(
            new OrderWasConfirmed(
                OrderId::fromString($this->orderId),
                EmployeeId::fromString($this->employeeId),
                new \DateTimeImmutable($this->confirmedAt)
            )
        );
    }

    function it_sends_invoices() {
        $this->confirm(
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );

        $this->flushEvents()->shouldContainEvent(
            new InvoiceWasSent(
                OrderId::fromString($this->orderId),
                $this->customerName,
                Money::fromCents($this->totalPriceCents, new Currency($this->currency)),
                new \DateTimeImmutable($this->confirmedAt)
            )
        );
    }

    function it_cannot_confirm_an_order_more_than_once() {
        $this->confirm(
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );
        $this->shouldThrow(CannotConfirmOrderMoreThanOnce::class)->during('confirm', [
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        ]);
    }

    function it_makes_payments() {
        $this->confirm(
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );

        $this->makePayment(
            Money::fromCents(100, new Currency('usd')),
            new \DateTimeImmutable('2017-07-27 15:16:17')
        );

        $this->flushEvents()->shouldContainEvent(
            new PaymentWasMade(
                OrderId::fromString($this->orderId),
                Money::fromCents(100, new Currency('usd')),
                new \DateTimeImmutable('2017-07-27 15:16:17')
            )
        );
    }

    function it_cannot_make_payments_on_unconfirmed_orders() {
        $this->shouldThrow(CannotMakePaymentsOnUnconfirmedOrders::class)->during('makePayment', [
            Money::fromCents($this->totalPriceCents, new Currency($this->currency)),
            new \DateTimeImmutable('2017-07-27 15:16:17')
        ]);
    }

    function it_cannot_make_payments_larger_than_the_total() {
        $this->confirm(
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );

        $this->shouldThrow(CannotPayMoreThanTotal::class)->during('makePayment', [
            Money::fromCents($this->totalPriceCents+1, new Currency($this->currency)),
            new \DateTimeImmutable('2017-07-27 15:16:17')
        ]);
    }

    function it_completes_orders_who_have_completed_payment() {
        $this->confirm(
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );

        $this->makePayment(
            Money::fromCents($this->totalPriceCents, new Currency($this->currency)),
            new \DateTimeImmutable('2017-07-27 15:16:17')
        );

        $this->flushEvents()->shouldContainEvent(
            new OrderWasCompleted(
                OrderId::fromString($this->orderId),
                new \DateTimeImmutable('2017-07-27 15:16:17')
            )
        );
    }

    function it_fulfills_orders() {
        $this->confirm(
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );

        $this->makePayment(
            Money::fromCents($this->totalPriceCents, new Currency($this->currency)),
            new \DateTimeImmutable('2017-07-27 15:16:17')
        );

        $this->fulfill(
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        );

        $this->flushEvents()->shouldContainEvent(
            new OrderWasFulfilled(
                OrderId::fromString($this->orderId),
                EmployeeId::fromString($this->employeeId),
                new \DateTimeImmutable($this->confirmedAt)
            )
        );
    }

    function it_cannot_fulfill_an_order_that_hasnt_been_completed() {
        $this->shouldThrow(CannotFulfillAnOrderThatHasNotBeenCompleted::class)->during('fulfill', [
            EmployeeId::fromString($this->employeeId),
            new \DateTimeImmutable($this->confirmedAt)
        ]);
    }
}
