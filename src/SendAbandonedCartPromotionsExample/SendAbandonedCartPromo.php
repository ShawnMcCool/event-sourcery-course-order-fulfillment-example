<?php namespace OrderFulfillment\SendAbandonedCartPromotionsExample;

use OrderFulfillment\CommandDispatch\Command;

class SendAbandonedCartPromo implements Command {

    /** @var CartId */
    private $cartId;
    /** @var Timestamp */
    private $identifiedAt;

    public function __construct(CartId $cartId, Timestamp $identifiedAt) {
        $this->cartId = $cartId;
        $this->identifiedAt = $identifiedAt;
    }

    public function cartId(): CartId {
        return $this->cartId;
    }

    public function identifiedAt(): Timestamp {
        return $this->identifiedAt;
    }
}