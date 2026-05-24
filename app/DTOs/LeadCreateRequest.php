<?php

namespace App\DTOs;

readonly class LeadCreateRequest
{
    /**
     * @param string $name
     * @param string|null $email
     * @param string $phone
     * @param int $campus_id
     * @param string $source
     * @param int|null $handler_id
     * @param string|null $notes
     * @param string|null $follow_up_date
     * @param bool $is_flag
     */
    public function __construct(
        public string $name,
        public ?string $email,
        public string $phone,
        public int $campus_id,
        public string $source,
        public ?int $handler_id,
        public ?string $notes,
        public ?string $follow_up_date,
        public bool $is_flag = false,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'campus_id' => $this->campus_id,
            'source' => $this->source,
            'handler_id' => $this->handler_id,
            'notes' => $this->notes,
            'follow_up_date' => $this->follow_up_date,
            'is_flag' => $this->is_flag,
        ];
    }
}
