@extends('customer-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h3 class="uk-card-title">Make a Payment</h3>

        <p>Order # order id</p>
        <p>Total Order Price: $32</p>

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

        <form class="uk-form-width-large">
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