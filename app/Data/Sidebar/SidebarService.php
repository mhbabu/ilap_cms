<?php

namespace App\Data\Sidebar;

use App\Models\User;
use Illuminate\Support\Collection;

readonly class SidebarService
{
    public function __construct(private User $user) {}

    /**
     * @return Collection<int, array{section: string, children: Collection<int, SidebarItem>}>
     */
    public function items(): Collection
    {
        $all = SidebarConfig::items();

        if ($this->user->hasRole('super_admin') || $this->user->hasRole('hq_admin')) {
            return collect($all);
        }

        return collect($all)->filter(function ($group) {
            $children = collect($group['children'])->filter(function (SidebarItem $item) {
                if ($item->permission === null || $item->permission === '') {
                    return true;
                }

                return $this->user->can($item->permission);
            });

            return $children->isNotEmpty();
        });
    }

    public function canAccess(string $routeName, ?string $requiredPermission = null): bool
    {
        if ($this->user->hasRole('super_admin') || $this->user->hasRole('hq_admin')) {
            return true;
        }

        if ($requiredPermission !== null && !$this->user->can($requiredPermission)) {
            return false;
        }

        return true;
    }
}
