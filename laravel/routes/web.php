<?php namespace App\Http\Controllers;

// Customer Interface
group(['fake-customer-session'], function() {
    test_route('/', function() {
        return view('index');
    });

    test_route('place-order', function() {
        return view('place-order');
    });

    post('place-order', PlaceOrder::class, 'place');
    get('thanks-for-your-order', PlaceOrder::class, 'thanks');

    test_route('make-payment', function() {
        return view('make-payment');
    });

    test_route('payment-received', function() {
        return view('payment-received');
    });
});

// Employee Interface
group(['fake-employee-session'], function() {

    get('confirm-order', ConfirmOrder::class, 'viewPlacedOrders');

    test_route('fulfill-order', function() {
        return view('fulfill-order');
    });
});