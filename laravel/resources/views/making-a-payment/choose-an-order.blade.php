@extends('customer-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h1 class="uk-card-title">Choose an Order for Payment</h1>

        <ul class="uk-list">
            @forelse($orders as $order)
                <li>
                    {{ $order->customerName() }}
                </li>
            @empty
                <li>No orders have been confirmed.</li>
            @endforelse
        </ul>
    </div>
@endsection