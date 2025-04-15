<?php

namespace App\Services;

use App\Dto\CandidateDTO;
use App\Enums\CandidateStatusEnum;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Tenant;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;

class CandidateService
{
    /**
     * @param Tenant $tenant
     * @return AbstractPaginator
     */
    public function all(Tenant $tenant): AbstractPaginator
    {
        $query = $this->selectCommonColumns(tenantId: $tenant->id)
            ->where('status', CandidateStatusEnum::ACTIVE->value);

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
        return Candidate::select(
            'id',
            'tenant_id',
            'uid',
            'status'
        )->with('tenant')
            ->where('tenant_id', $tenantId);
    }

    public function findByUid(Tenant $tenant, string $uid, array $with = []): Candidate|null
    {
        return $this->selectCommonColumns(tenantId: $tenant->id)
            ->where('uid', $uid)
            ->with($with)
            ->first();
    }

    /**
     * @param Tenant $tenant
     * @param array $data
     * @return CandidateDTO
     */
    public function prepareDtoCreate(Tenant $tenant, array $data): CandidateDTO
    {
        $status = Arr::get($data, 'status') ? CandidateStatusEnum::ACTIVE->value : CandidateStatusEnum::INACTIVE->value;
        return new CandidateDTO(
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
        return Candidate::query()->create($data->toArray());
    }

    /**
     * @param array $data
     * @param Candidate $candidate
     * @return CandidateDTO
     */
    public function prepareDtoUpdate(array $data, Candidate $candidate): CandidateDTO
    {
        $status = Arr::get($data, 'status') ?: $candidate->satus;

        return new CandidateDTO(
            uid: $candidate->uid,
            tenant_id: $application->tenant_id,
            status: $status
        );
    }

    /**
     * @param CandidateDTO $data
     * @param $customer
     * @return mixed
     */
    public function update(CandidateDTO $data, $customer): mixed
    {
        $customer->update($data->toArray());
        return $customer;
    }
}
