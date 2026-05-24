<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class VideoLibraryPolicy
{
    public function manageVideos(User $user): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not have permission to access this section.');
    }
}
