<?php

namespace App\Utilities;

trait DBSchemaTrait
{
    public function uid(string $column = 'uid', $length = 36)
    {
        return $this->string($column, $length)->unique();
    }

}
