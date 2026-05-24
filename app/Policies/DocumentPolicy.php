<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    public function view(User $user, Document $document): Response
    {
        if ($user->hasRole('super_admin')) return Response::allow();
        if ((int) $user->campus_id === (int) $document->campus_id) return Response::allow();
        return Response::deny();
    }

    public function upload(User $user): Response
    {
        return $user->hasRole('super_admin') || $user->hasRole('campus_admin')
            || $user->hasRole('campus_manager') || $user->hasRole('handler')
                ? Response::allow()
                : Response::deny();
    }

    public function delete(User $user, Document $document): Response
    {
        if ($user->hasRole('super_admin')) return Response::allow();
        return $user->id === $document->uploaded_by ? Response::allow() : Response::deny();
    }
}
