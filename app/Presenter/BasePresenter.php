<?php

namespace App\Presenter;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nahid\Presento\Presenter;

abstract class BasePresenter extends Presenter
{
    public function init(mixed $data)
    {
        if ($data instanceof Model ||
            $data instanceof Collection ||
            $data instanceof Arrayable
        ) {
            return $data->toArray();
        }

        if (is_object($data)) {
            return (array) $data;
        }

        return $data;
    }
}
