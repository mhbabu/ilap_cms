<?php

namespace App\Data\Sidebar;

readonly class SidebarItem
{
    public function __construct(
        public string $icon,
        public string $label,
        public string $route,
        public ?string $permission = null,
        public ?array $children = null,
    ) {}

    public function canAccess(?string $userRole): bool
    {
        if ($this->permission === null) {
            return true;
        }
        return true;
    }

    public function hasPermission(): bool
    {
        return $this->permission !== null;
    }

    public function getPermission(): string
    {
        return $this->permission ?? '';
    }
}
