@extends('employee-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h3 class="uk-card-title">Fulfill Orders</h3>

        <form class="uk-form-width-large">
            <ul class="uk-list">
                @forelse($orders as $order)
                    <li>
                        <strong>Order {{ $order->customer_name }}</strong> placed {{ $order->placedAt() }}
                        <div>{{ $order->delimitedProductList() }}</div>
                        <div>{{ $order->totalPriceWithCurrency() }}</div>
                        <a href="/fulfill-an-order/fulfill-order/{{ $order->orderId() }}">Make a payment on this order.</a>
                    </li>
                @empty
                    <li>No orders have been completed.</li>
                @endforelse
            </ul>
        </form>
    </div>
@endsection