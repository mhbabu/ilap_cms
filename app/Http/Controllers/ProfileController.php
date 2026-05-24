<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = auth()->user();

        return $this->withOrg('profile.show', [
            'user' => $user->load(['campus', 'enrollments', 'payments', 'tickets', 'documents']),
        ]);
    }
}
