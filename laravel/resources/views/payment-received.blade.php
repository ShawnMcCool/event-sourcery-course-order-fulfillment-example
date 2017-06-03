@extends('customer-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h3 class="uk-card-title">Payment Received</h3>

        <p>Order # order id</p>
        <p>Total Order Price: $32</p>

        Payments:
        <ul class="uk-list">
            <li>
                <strong>Payment</strong>
                $31.75
            </li>
            <li>
                <strong>Payment</strong>
                $2.12
            </li>
        </ul>

    </div>
@endsection