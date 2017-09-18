@extends('employee-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h3 class="uk-card-title">Confirm Orders</h3>

        <form class="uk-form-width-large">
            <ul class="uk-list">
                @forelse($orders as $order)
                    <li>
                        <strong>Order {{ $order->customer_name }}</strong> placed {{ $order->placedAt() }}
                        <div>{{ $order->delimitedProductList() }}</div>
                        <div>{{ $order->totalPriceWithCurrency() }}</div>
                        <a href="#">Confirm</a>
                    </li>
                @empty
                    <p><li>no orders</li></p>
                @endforelse
                {{--<li>--}}
                    {{--<strong>Order 2</strong>--}}
                    {{--<div>Product 2</div>--}}
                    {{--<a href="#">Confirm</a>--}}
                {{--</li>--}}
            </ul>
        </form>
    </div>
@endsection