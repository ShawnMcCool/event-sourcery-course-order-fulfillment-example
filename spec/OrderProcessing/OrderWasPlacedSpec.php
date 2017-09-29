<?php namespace spec\OrderFulfillment\OrderProcessing;

use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;
use OrderFulfillment\OrderProcessing\CustomerId;
use OrderFulfillment\OrderProcessing\OrderId;
use OrderFulfillment\OrderProcessing\ProductId;
use PhpSpec\ObjectBehavior;

class OrderWasPlacedSpec extends ObjectBehavior {

    private $orderId = 'order id';
    private $customerId = 'customer id';
    private $customerName = 'customer name';
    private $products = ['product id 1', 'product id 2'];
    private $totalPrice = '1200';
    private $currency = 'USD';
    private $placedAt = '2017-01-01 23:21:23';

    function let() {
        $this->beConstructedWith(
            OrderId::fromString($this->orderId),
            CustomerId::fromString($this->customerId),
            $this->customerName,
            array_map(function ($productId) {
                return ProductId::fromString($productId);
            }, $this->products),
            Money::fromCents($this->totalPrice, new Currency($this->currency)),
            new \DateTimeImmutable($this->placedAt)
        );
    }

    function it_can_be_initialized() {
        $this->orderId()->shouldEqualValue(OrderId::fromString($this->orderId));
        $this->customerId()->shouldEqualValue(CustomerId::fromString($this->customerId));
        $this->customerName()->shouldBe($this->customerName);
        $this->products()->shouldEqualValues(
            ProductId::fromString($this->products[0]),
            ProductId::fromString($this->products[1])
        );
        $this->totalPrice()->shouldEqualValue(Money::fromCents($this->totalPrice, new Currency($this->currency)));
        $this->placedAt()->format('Y-m-d H:i:s')->shouldBe($this->placedAt);
    }

    function it_can_be_serialized() {
        $this->serialize()->shouldReturn([
            'orderId'         => $this->orderId,
            'customerId'      => $this->customerId,
            'customerName'    => $this->customerName,
            'products'        => $this->products,
            'totalPriceCents' => $this->totalPrice,
            'currency'        => $this->currency,
            'placedAt'        => $this->placedAt,
        ]);
    }

    function it_can_be_deserialized() {
        $this->beConstructedThrough('deserialize', [[
            'orderId'         => 'diff order id',
            'customerId'      => 'diff customer id',
            'customerName'    => 'diff customer name',
            'products'        => ['diff products', 'more even', 'some more'],
            'totalPriceCents' => '1234',
            'currency'        => 'EUR',
            'placedAt'        => '2014-07-27 12:13:14',
        ]]);
        $this->orderId()->shouldEqualValue(OrderId::fromString('diff order id'));
        $this->customerId()->shouldEqualValue(CustomerId::fromString('diff customer id'));
        $this->customerName()->shouldBe('diff customer name');
        $this->products()->shouldEqualValues(
            ProductId::fromString('diff products'),
            ProductId::fromString('more even'),
            ProductId::fromString('some more')
        );
        $this->totalPrice()->shouldEqualValue(Money::fromCents('1234', new Currency('EUR')));
        $this->placedAt()->format('Y-m-d H:i:s')->shouldBe('2014-07-27 12:13:14');
    }
}