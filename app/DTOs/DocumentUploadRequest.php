<?php

namespace App\DTOs;

readonly class DocumentUploadRequest
{
    /**
     * @param string $title
     * @param string|null $description
     * @param int $campus_id
     * @param int|null $student_id
     * @param string $type
     * @param bool $is_guide_document
     * @param bool $is_template
     * @param string $file_path
     */
    public function __construct(
        public string $title,
        public ?string $description,
        public int $campus_id,
        public ?int $student_id,
        public string $type,
        public bool $is_guide_document = false,
        public bool $is_template = false,
        public string $file_path,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'campus_id' => $this->campus_id,
            'student_id' => $this->student_id,
            'type' => $this->type,
            'is_guide_document' => $this->is_guide_document,
            'is_template' => $this->is_template,
            'file_path' => $this->file_path,
        ];
    }
}
