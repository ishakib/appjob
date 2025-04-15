<?php

namespace App\Services;

use App\Dto\ApplicationDTO;
use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use App\Models\Tenant;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;

class ApplicationService
{

    /**
     * @param Tenant $tenant
     * @return AbstractPaginator
     */
    public function all(Tenant $tenant): AbstractPaginator
    {
        $query = $this->selectCommonColumns(tenantId: $tenant->id)
            ->whereIn('status', [ApplicationStatusEnum::IN_PROGRESS, ApplicationStatusEnum::PENDING, ApplicationStatusEnum::HOLD]);

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
        return Application::select(
            'id',
            'tenant_id',
            'uid',
            'status'
        )->with('tenant')
            ->where('tenant_id', $tenantId);
    }

    public function findByUid(Tenant $tenant, string $uid, array $with = []): Application|null
    {
        return $this->selectCommonColumns(tenantId: $tenant->id)
            ->where('uid', $uid)
            ->with($with)
            ->first();
    }

    /**
     * @param Tenant $tenant
     * @param array $data
     * @return ApplicationDTO
     */
    public function prepareDtoCreate(Tenant $tenant, array $data): ApplicationDTO
    {
        $status = Arr::get($data, 'status') ? ApplicationStatusEnum::PENDING->value : ApplicationStatusEnum::ANY->value;
        return new ApplicationDTO(
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
        return Application::query()->create($data->toArray());
    }

    /**
     * @param array $data
     * @param $application
     * @return ApplicationDTO
     */
    public function prepareDtoUpdate(array $data, $application): ApplicationDTO
    {
        $status = Arr::get($data, 'status') ?: $application->satus;

        return new ApplicationDTO(
            uid: $application->uid,
            tenant_id: $application->tenant_id,
            status: $status
        );
    }

    /**
     * @param ApplicationDTO $data
     * @param $customer
     * @return mixed
     */
    public function update(ApplicationDTO $data, $customer): mixed
    {
        $customer->update($data->toArray());
        return $customer;
    }
}
