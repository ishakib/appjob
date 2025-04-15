<?php

namespace App\Services;

use App\Dto\JobpostDTO;
use App\Enums\JobStatusEnum;
use App\Models\JobPost;
use App\Models\Tenant;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;

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

    /**
     * @param Tenant $tenant
     * @param array $data
     * @return JobpostDTO
     */
    public function prepareDtoCreate(Tenant $tenant, array $data): JobpostDTO
    {
        $status = Arr::get($data, 'status') ? JobStatusEnum::ACTIVE->value : JobStatusEnum::INACTIVE->value;
        return new JobpostDTO(
            uid: str_unique_with_prefix('jp-'),
            tenant_id: (int)$tenant->id,
            status: $status
        );
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data): mixed
    {
        return JobPost::query()->create($data->toArray());
    }

    /**
     * @param array $data
     * @param JobPost $jobPost
     * @return JobpostDTO
     */
    public function prepareDtoUpdate(array $data, JobPost $jobPost): JobpostDTO
    {
        $status = Arr::get($data, 'status') ?: $jobPost->satus;

        return new JobpostDTO(
            uid: $jobPost->uid,
            tenant_id: $jobPost->tenant_id,
            status: $status
        );
    }

    /**
     * @param JobpostDTO $data
     * @param $customer
     * @return mixed
     */
    public function update(JobpostDTO $data, $customer): mixed
    {
        $customer->update($data->toArray());
        return $customer;
    }
}
