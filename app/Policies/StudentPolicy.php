<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{
    public function view(User $user, Student $student): Response
    {
        if ($user->hasRole('super_admin')) return Response::allow();
        if ($user->hasRole('hq_admin')) return Response::allow();
        if ((int) $user->campus_id === (int) $student->campus_id) return Response::allow();
        return Response::deny();
    }

    public function update(User $user, Student $student): Response
    {
        if ($user->hasRole('super_admin')) return Response::allow();
        if ($user->campus_id === $student->campus_id && $user->hasRole('campus_admin')) return Response::allow();
        if ($user->campus_id === $student->campus_id && $user->hasRole('campus_manager')) return Response::allow();
        return Response::deny();
    }

    public function assignHandler(User $user): Response
    {
        return $user->hasRole('campus_admin') || $user->hasRole('campus_manager') || $user->hasRole('hq_admin')
            ? Response::allow()
            : Response::deny();
    }
}
