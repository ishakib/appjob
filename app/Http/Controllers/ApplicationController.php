<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationCreateRequest;
use App\Http\Requests\ApplicationUpdateRequest;
use App\Jobs\AfterApplicationNotifyJob;
use App\Presenter\ApplicationPresenter;
use App\Services\ApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * @param ApplicationService $applicationService
     */
    public function __construct(protected ApplicationService $applicationService)
    {
    }


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $applications = $this->applicationService->all(tenant());
        return api([
            'jobs' => (new ApplicationPresenter($applications->toArray()['data']))() ?? [],
            'meta' => pagination_meta($applications)
        ])->success(__('response.success'));
    }


    /**
     * @param ApplicationCreateRequest $request
     * @return JsonResponse
     */
    public function store(ApplicationCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $applicationDTO = $this->applicationService->prepareDtoCreate(tenant(), $request->validated());

            $application = $this->applicationService->store($applicationDTO);

            dispatch(new AfterApplicationNotifyJob(tenant()));

            DB::commit();

            return api((new ApplicationPresenter($application))())->success(__('application.create.success'));

        } catch (\Exception $e) {
            DB::rollBack();
            return api()->fails(__('response.fail'));
        }
    }

    /**
     * @param string $uid
     * @return JsonResponse
     */
    public function show(string $uid): JsonResponse
    {
        $application = $this->applicationService->findByUid(tenant(),$uid);

        if ($application === null) {
            return api()->fails(__('response.fail'));
        }

        return api((new ApplicationPresenter($application))())->success(__('response.success'));
    }

    /**
     * @param ApplicationUpdateRequest $request
     * @param string $uid
     * @return JsonResponse
     */
    public function update(ApplicationUpdateRequest $request, string $uid): JsonResponse
    {
        try {

            if (!tenant()) {
                return api()->fails(__('response.fail'));
            }

            $application = $this->applicationService->findByUid(tenant(), $uid);

            if ($application === null) {
                return api()->fails(__('response.fail'));
            }

            $categoryDTO = $this->applicationService->prepareDtoUpdate($request->all(), $application);

            $this->applicationService->update($categoryDTO, $application);

            return api((new ApplicationPresenter($application))())->success(__('application.update.success'));

        } catch (\Exception $e) {
            return api()->fails(__('response.fail'));
        }
    }

    /**
     * @param string $uid
     * @return JsonResponse
     */
    public function destroy(string $uid): JsonResponse
    {
        try {

            $application = $this->applicationService->findByUid(tenant(), $uid);

            if (!$application) {
                return api()->fails(__('response.fail'));
            }

            $application->delete();

            return api((new ApplicationPresenter())())->success(__('application.delete.success'));

        } catch (\Exception $e) {
            return api()->fails(__('response.fail'));
        }
    }
}
