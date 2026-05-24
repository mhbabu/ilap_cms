<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    public function view(User $user, Ticket $ticket): Response
    {
        if ($user->hasRole('super_admin') || $user->hasRole('hq_admin'))
            return Response::allow();

        if ($user->campus_id === $ticket->campus_id)
            return Response::allow();

        return Response::deny();
    }

    public function update(User $user, Ticket $ticket): Response
    {
        return $this->view($user, $ticket);
    }

    public function assign(User $user): Response
    {
        return $user->hasRole('super_admin') || $user->hasRole('hq_admin') || $user->hasRole('campus_admin')
            ? Response::allow()
            : Response::deny();
    }

    public function delete(User $user, Ticket $ticket): Response
    {
        return $user->hasRole('super_admin')
            ? Response::allow()
            : Response::deny();
    }
}
