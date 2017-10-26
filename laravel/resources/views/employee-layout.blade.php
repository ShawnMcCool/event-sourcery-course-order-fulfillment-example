<!DOCTYPE html>
<html class="uk-background-muted">
<head>
    <title>Order Fulfillment</title>
    <link rel="stylesheet" href="/css/uikit.min.css"/>
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
        <a class="uk-navbar-item uk-logo" href="#">Employee Interface</a>

        <!-- Navigation Links -->
        <ul class="uk-navbar-nav">
            <li>
                <a href="/confirm-an-order/select-order-to-confirm">Confirm Orders</a>
            </li>
            <li>
                <a href="/fulfill-an-order/choose-an-order">Fulfill Orders</a>
            </li>
            <li>
                <a href="/place-an-order/view-products">Customer Interface</a>
            </li>
        </ul>

    </div>

    <!-- top right nav-->
    <div class="uk-navbar-right uk-background-default">
        <div class="uk-navbar-item uk-background-primary uk-light">
            {{ Session::get('employee_name') }}
        </div>
    </div>
</nav>

@yield('content')

</body>
</html>
