<?php namespace App\Http\Controllers;

test_route('/', function() {
    return view('index');
});

test_route('place-order', function() {
    return view('place-order');
});

test_route('confirm-order', function() {
    return view('confirm-order');
});

test_route('make-payment', function() {
    return view('make-payment');
});

test_route('payment-received', function() {
    return view('payment-received');
});

test_route('fulfill-order', function() {
    return view('fulfill-order');
});