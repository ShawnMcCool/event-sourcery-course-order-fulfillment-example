<?php namespace OrderFulfillment\SendAbandonedCartPromotionsExample;

use OrderFulfillment\EventSourcing\DomainEvent;

class ProductWasAddedToCart implements DomainEvent {

    /** @var CartId */
    private $cartId;
    /** @var ProductId */
    private $productId;
    /** @var Timestamp */
    private $addedAt;

    public function __construct(CartId $cartId, ProductId $productId, Timestamp $addedAt) {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->addedAt = $addedAt;
    }

    //...

    public function serialize(): array {

    }

    public static function deserialize(array $data): DomainEvent {

    }
}