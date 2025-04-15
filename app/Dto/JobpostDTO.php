<?php

namespace App\Dto;

class JobpostDTO extends AbstractDTO
{
    private array $_toArrayData = [];

    public function __construct(
        public string  $uid,
        public int     $tenant_id,
        public int     $status = 1,
    )
    {
        // Initialize any default values or transformations here if needed
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'tenant_id' => $this->tenant_id,
            'status' => $this->status,
        ];
    }

}
