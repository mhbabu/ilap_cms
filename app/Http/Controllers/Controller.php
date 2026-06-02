<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Data\Sidebar\SidebarService;

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
            'primaryColor'  => $campus?->color_primary ?? '#1e40af',
            'secondaryColor'=> $campus?->color_secondary ?? '#3b82f6',
            'appName'       => config('app.name'),
            'user'          => auth()->user(),
            'sidebarItems'  => (new SidebarService(auth()->user() ?? new User()))->items(),
        ], $data);

        return view($view, $data);
    }

    protected function campusOrHqQuery(string|Model $model): \Illuminate\Database\Eloquent\Builder
    {
        $query = $model instanceof Model ? $model->query() : ($model::query());
        $user  = auth()->user();

        if ($user?->hasRole('super_admin') || $user?->hasRole('hq_admin')) {
            return $query;
        }

        return $query->where('campus_id', $user?->campus_id);
    }
}
