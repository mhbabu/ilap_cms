<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class Controller extends BaseController
{
    /**
     * Shared logic for all controllers.
     */
    protected function withOrg(string $view, array $data = []): View
    {
        $campus = auth()->user()?->campus;
        $data   = array_merge([
            'campus'        => $campus,
            'orgName'       => $campus?->name ?? 'iLAP HQ',
            'primaryColor'  => $campus?->primary_color ?? '#1e40af',
            'secondaryColor'=> $campus?->secondary_color ?? '#3b82f6',
            'appName'       => config('app.name'),
            'user'          => auth()->user(),
        ], $data);

        return view($view, $data);
    }

    protected function campusOrHqQuery(Model $model)
    {
        $user  = auth()->user();
        if ($user?->hasRole('super_admin') || $user?->hasRole('hq_admin'))
            return $model->query();
        return $model->query()->where('campus_id', $user?->campus_id);
    }
}
