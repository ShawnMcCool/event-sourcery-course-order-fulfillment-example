@extends('employee-layout')

@section('content')
    <div class="uk-card uk-background-default uk-position-center uk-card-body uk-box-shadow-large uk-width-auto">
        <h3 class="uk-card-title">Confirm Orders</h3>

        <form class="uk-form-width-large">
            <ul class="uk-list">
                <li>
                    <strong>Order 1</strong>
                    <div>Product 1, Product 2</div>
                    <a href="#">Confirm</a>
                </li>
                <li>
                    <strong>Order 2</strong>
                    <div>Product 2</div>
                    <a href="#">Confirm</a>
                </li>
            </ul>
        </form>
    </div>
@endsection