<?php namespace OrderFulfillment\SendAbandonedCartPromotionsExample;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\Money\Money;

class CheckoutWasCompleted implements DomainEvent {

    /** @var CartId */
    private $cartId;
    /** @var Money */
    private $totalPrice;
    /** @var Timestamp */
    private $checkedOutAt;

    public function __construct(CartId $cartId, Money $totalPrice, Timestamp $checkedOutAt) {
        $this->cartId = $cartId;
        $this->totalPrice = $totalPrice;
        $this->checkedOutAt = $checkedOutAt;
    }

    public function cartId(): CartId {
        return $this->cartId;
    }

    public function totalPrice(): Money {
        return $this->totalPrice;
    }

    public function checkedOutAt(): Timestamp {
        return $this->checkedOutAt;
    }

    //...

    public function serialize(): array {

    }

    public static function deserialize(array $data): DomainEvent {

    }
}