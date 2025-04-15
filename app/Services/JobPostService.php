<?php

namespace App\Services;

use App\Enums\JobStatusEnum;
use App\Models\JobPost;
use App\Models\Tenant;
use Illuminate\Pagination\AbstractPaginator;

class JobPostService
{
    /**
     * @param Tenant $tenant
     * @return AbstractPaginator
     */
    public function all(Tenant $tenant): AbstractPaginator
    {
        $query = $this->selectCommonColumns(tenantId: $tenant->id)
            ->where('status', JobStatusEnum::ACTIVE->value);

        if (!request()->input('sort_by')) {
            $query->orderBy('id', 'DESC');
        }

        return $query->paginate(request()->input('per_page', 10));
    }

    /**
     * @param int $tenantId
     * @return mixed
     */
    protected function selectCommonColumns(int $tenantId): mixed
    {
        return JobPost::select(
                'id',
                'tenant_id',
                'uid',
                'title',
                'slug',
                'description',
                'view_count',
                'application_count',
                'status'
            )->with('tenant')
            ->where('tenant_id', $tenantId);
    }

    public function findByUid(Tenant $tenant, string $uid, array $with = []): JobPost|null
    {
        return $this->selectCommonColumns(tenantId: $tenant->id)
            ->where('uid', $uid)
            ->with($with)
            ->first();
    }

}
