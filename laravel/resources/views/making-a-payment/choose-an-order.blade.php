@extends('customer-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h1 class="uk-card-title">Choose an Order for Payment</h1>

        <ul class="uk-list">
            @forelse($orders as $order)
                <li>
                    <strong>Order {{ $order->customer_name }}</strong> placed {{ $order->placedAt() }}
                    <div>{{ $order->delimitedProductList() }}</div>
                    <div>{{ $order->totalPriceWithCurrency() }}</div>
                    <a href="/make-a-payment/make-a-payment/{{ $order->orderId() }}">Make a payment on this order.</a>
                </li>
            @empty
                <li>No orders have been confirmed.</li>
            @endforelse
        </ul>
    </div>
@endsection