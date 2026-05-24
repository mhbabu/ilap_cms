<?php

namespace App\DTOs;

readonly class CampusCreateRequest
{
    /**
     * @param string $name
     * @param string $code
     * @param string|null $address
     * @param string|null $city
     * @param string|null $phone
     * @param string|null $email
     * @param int|null $manager_user_id
     * @param int|null $hq_id
     * @param string|null $color_primary
     * @param string|null $color_secondary
     */
    public function __construct(
        public string $name,
        public string $code,
        public ?string $address,
        public ?string $city,
        public ?string $phone,
        public ?string $email,
        public ?int $manager_user_id,
        public ?int $hq_id,
        public ?string $color_primary,
        public ?string $color_secondary,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'address' => $this->address,
            'city' => $this->city,
            'phone' => $this->phone,
            'email' => $this->email,
            'manager_user_id' => $this->manager_user_id,
            'hq_id' => $this->hq_id,
            'color_primary' => $this->color_primary,
            'color_secondary' => $this->color_secondary,
        ];
    }
}
