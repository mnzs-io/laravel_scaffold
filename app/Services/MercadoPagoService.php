<?php

namespace App\Services;

use App\Contracts\Payment\PaymentCustomer;
use App\Contracts\Payment\PaymentGateway;
use App\Contracts\Payment\PaymentPlan;
use App\Models\User;

class MercadoPagoService implements PaymentGateway
{
    public static function createCustomer(User $user): PaymentCustomer
    {
        return $user;
    }

    public static function createSubscription(User $user, PaymentPlan $plan): bool
    {
        return true;
    }

    public static function cancelSubscription(User $user, PaymentPlan $plan): bool
    {
        return true;
    }
}
