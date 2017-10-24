<?php namespace OrderFulfillment\OrderProcessing;

use OrderFulfillment\EventSourcing\DomainEvent;
use OrderFulfillment\Money\Currency;
use OrderFulfillment\Money\Money;

class PaymentWasMade implements DomainEvent
{

    /** @var OrderId */
    private $orderId;
    /** @var Money */
    private $amount;
    /** @var \DateTimeImmutable */
    private $paidAt;

    public function __construct(OrderId $orderId, Money $amount, \DateTimeImmutable $paidAt)
    {
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->paidAt = $paidAt;
    }

    public function serialize(): array {
        return [
            'orderId' => $this->orderId->toString(),
            'amountCents' => $this->amount->toCents(),
            'amountCurrency' => $this->amount->currency()->toString(),
            'paidAt' => $this->paidAt->format('Y-m-d H:i:s')
        ];
    }

    public static function deserialize(array $data): DomainEvent {
        return new static(
            OrderId::fromString($data['orderId']),
            Money::fromCents($data['amountCents'], new Currency($data['amountCurrency'])),
            new \DateTimeImmutable($data['paidAt'])
        );
    }

    public function orderId(): OrderId {
        return $this->orderId;
    }

    public function amount(): Money {
        return $this->amount;
    }

    public function paidAt(): \DateTimeImmutable {
        return $this->paidAt;
    }
}
