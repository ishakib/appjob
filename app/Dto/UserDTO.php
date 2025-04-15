<?php

namespace App\Dto;

class UserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public UserStatus $status
    ) {}

    /**
     * Create a DTO from an array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            status: UserStatus::from($data['status'])
        );
    }

    /**
     * Convert DTO to an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status->value,
        ];
    }

}
