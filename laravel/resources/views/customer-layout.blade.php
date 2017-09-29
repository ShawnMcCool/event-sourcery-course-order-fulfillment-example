<!DOCTYPE html>
<html class="uk-background-muted">
<head>
    <title>Order Fulfillment</title>
    <link rel="stylesheet" href="/css/uikit.min.css" />
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="/js/uikit.min.js"></script>
    <script src="/js/uikit-icons.min.js"></script>
</head>
<body>
    <!-- top nav -->
    <nav class="uk-navbar-container uk-margin" uk-navbar>
        <!-- top left nav -->
        <div class="uk-navbar-left uk-background-default uk-width-expand">

            <!-- Logo -->
            <a class="uk-navbar-item uk-logo" href="#">Customer Interface</a>

            <!-- Navigation Links -->
            <ul class="uk-navbar-nav">
                <li>
                    <a href="/place-an-order/view-products">Place an Order</a>
                </li>
                <li>
                    <a href="/make-a-payment/choose-an-order">Make a Payment</a>
                </li>
                <li>
                    <a href="/confirm-an-order/select-order-to-confirm">Employee Interface</a>
                </li>
            </ul>

        </div>

        <!-- top right nav-->
        <div class="uk-navbar-right uk-background-default">
            <div class="uk-navbar-item uk-background-primary uk-light">
                {{ Session::get('customer_name') }}
            </div>
        </div>
    </nav>

    @yield('content')

</body>
</html>