<?php

namespace App\Actions\Payment;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class CheckoutAction
{
    public function __invoke()
    {

        MercadoPagoConfig::setAccessToken(config('services.mercado_pago.access_token'));

        $client = new PreferenceClient;
        $preference = $client->create([
            'items' => [
                [
                    'title' => 'Meu produto',
                    'quantity' => 1,
                    'unit_price' => 2000,
                ],
            ],
        ]);

        dd($preference);
    }
}
