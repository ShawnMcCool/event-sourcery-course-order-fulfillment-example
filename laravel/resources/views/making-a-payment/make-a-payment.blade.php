@extends('customer-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h3 class="uk-card-title">Make a Payment</h3>

        <p>Order # {{ $order->orderId() }}</p>
        <p>Total Order Price: {{ $order->totalPriceWithCurrency() }}</p>

        <p>Payments<br/>
            @if($payments->isEmpty())
                No payments have been made on this order.
            @else
                <ul class="uk-list">
                    @foreach($payments as $payment)
                        <li>
                            <strong>Payment</strong>
                            {{ $payment->amountWithCurrency() }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </p>

        <form method="post" class="uk-form-width-large">
            <ul class="uk-list">
                <li>
                    Amount: <input type="text" name="payment_amount"/>
                </li>
                <li>
                    Credit Card
                    <input type="text" name="credit_card_number" value="4222 2222 2222 2222"/>
                </li>
                <li>
                    <input type="submit" value="Make Payment"/>
                </li>
            </ul>
        </form>

    </div>
@endsection