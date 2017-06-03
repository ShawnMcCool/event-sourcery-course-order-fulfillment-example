@extends('customer-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h3 class="uk-card-title">Place Order</h3>

        <form class="uk-form-width-large">
            <ul class="uk-list">
                <li>
                    Product 1 <a href="#">Add to Cart</a>
                </li>
                <li>
                    Product 2 <a href="#">Add to Cart</a>
                </li>
            </ul>
        </form>

        <h3 class="uk-card-title">Your Cart</h3>

        <form class="uk-form-width-large">
            <ul class="uk-list">
                <li>
                    Product 1 <a href="#">Remove</a>
                </li>
                <li>
                    Product 2 <a href="#">Remove</a>
                </li>
            </ul>
            <input type="submit" value="Place Order"/>
        </form>
    </div>
@endsection