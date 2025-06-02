<?php

namespace App\Contracts\Payment;

use App\Models\User;

interface PaymentGateway
{
    public static function createCustomer(User $user): PaymentCustomer;

    public static function createSubscription(PaymentCustomer $user, PaymentPlan $plan): bool;

    public static function cancelSubscription(PaymentCustomer $user, PaymentPlan $plan): bool;
}
