<?php

namespace App\DTOs;

readonly class StudentCreateRequest
{
    /**
     * @param string $name
     * @param string|null $email
     * @param string $phone
     * @param string|null $passport_number
     * @param float|null $ielts_score
     * @param string|null $qualification
     * @param int $campus_id
     * @param int|null $handler_id
     * @param string|null $address
     * @param string|null $date_of_birth
     * @param string|null $parent_phone
     * @param string|null $parent_email
     * @param string|null $enrollment_type
     * @param bool $is_pro
     */
    public function __construct(
        public string $name,
        public ?string $email,
        public string $phone,
        public ?string $passport_number,
        public ?float $ielts_score,
        public ?string $qualification,
        public int $campus_id,
        public ?int $handler_id,
        public ?string $address,
        public ?string $date_of_birth,
        public ?string $parent_phone,
        public ?string $parent_email,
        public ?string $enrollment_type,
        public bool $is_pro = false,
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
            'passport_number' => $this->passport_number,
            'ielts_score' => $this->ielts_score,
            'qualification' => $this->qualification,
            'campus_id' => $this->campus_id,
            'handler_id' => $this->handler_id,
            'address' => $this->address,
            'date_of_birth' => $this->date_of_birth,
            'parent_phone' => $this->parent_phone,
            'parent_email' => $this->parent_email,
            'enrollment_type' => $this->enrollment_type,
            'is_pro' => $this->is_pro,
        ];
    }
}
