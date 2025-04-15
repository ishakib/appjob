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
            'description',
            'view_count',
            'application_count',
            'company_name' => 'tenant.name'
        ];
    }

}
