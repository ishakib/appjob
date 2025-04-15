<?php

namespace App\Presenter;

class JobPostPresenter extends BasePresenter
{
    public function present(): array
    {
        return [
            'uid',
            'title',
            'slug',
            'descrption',
            'view_count',
            'application_count',
            'company_name' => 'tenant.name'
        ];
    }

}
