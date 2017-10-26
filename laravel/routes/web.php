<?php namespace App\Http\Controllers;

// Customer Interface
group(['fake-customer-session'], function () {
    // main menu
    test_route('/', function () {
        return view('index');
    });

    // place an order
    get('place-an-order/view-products', PlaceOrder::class, 'viewProducts');
    post('place-an-order/place-order', PlaceOrder::class, 'placeOrder');
    get('place-an-order/thanks-for-your-order', PlaceOrder::class, 'thanksForYourOrder');

    // make a payment
    get('make-a-payment/choose-an-order', MakePayment::class, 'chooseAnOrder');
    get('make-a-payment/make-a-payment/{orderId}', MakePayment::class, 'makeAPaymentForm');
    post('make-a-payment/make-a-payment/{orderId}', MakePayment::class, 'makeAPayment');
    get('make-a-payment/payment-was-made', MakePayment::class, 'paymentWasMade');
});

// Employee Interface
group(['fake-employee-session'], function () {
    // confirm an order
    get('confirm-an-order/select-order-to-confirm', ConfirmOrder::class, 'selectOrderToConfirm');
    get('confirm-an-order/confirm-order/{orderId}', ConfirmOrder::class, 'confirmOrder');
    get('confirm-an-order/order-was-confirmed', ConfirmOrder::class, 'orderWasConfirmed');

    // fullfill the order
    get('fulfill-an-order/choose-an-order', FulfillOrder::class, 'selectOrderToFulfill');
    get('fulfill-an-order/fulfill-order/{orderId}', FulfillOrder::class, 'fulfillOrder');
    get('fulfill-an-order/order-was-fulfilled', FulfillOrder::class, 'orderWasFulfilled');
});