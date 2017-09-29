@extends('employee-layout')

@section('content')
    <div class="uk-container">

        <h1 class="uk-card-title">Select an Order to Confirm</h1>

        <ul class="uk-list">
            @forelse($orders as $order)
                <li>
                    <strong>Order {{ $order->customer_name }}</strong> placed {{ $order->placedAt() }}
                    <div>{{ $order->delimitedProductList() }}</div>
                    <div>{{ $order->totalPriceWithCurrency() }}</div>
                    <a href="/confirm-an-order/confirm-order/{{ $order->orderId() }}">Confirm</a>
                </li>
            @empty
                <p><li>no orders</li></p>
            @endforelse
        </ul>
    </div>
@endsection