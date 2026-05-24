<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
{
    public function view(User $user, Payment $payment): Response
    {
        if ($user->hasRole('super_admin') || $user->hasRole('hq_admin'))
            return Response::allow();

        if ($user->campus_id === $payment->campus_id)
            return Response::allow();

        return Response::deny();
    }

    public function approve(User $user): Response
    {
        return $user->hasRole('super_admin') || $user->hasRole('hq_admin') || $user->hasRole('campus_admin')
            ? Response::allow()
            : Response::deny();
    }

    public function delete(User $user, Payment $payment): Response
    {
        return $user->hasRole('super_admin')
            ? Response::allow()
            : Response::deny();
    }
}
