<?php

use App\Actions\Payment\CheckoutAction;

use function App\Support\get;
use function App\Support\middleware;

middleware('web.authenticated', function () {
    get('/checkout', CheckoutAction::class);
});
