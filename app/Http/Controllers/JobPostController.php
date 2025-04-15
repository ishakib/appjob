<?php

namespace App\Http\Controllers;

use App\Presenter\JobPostPresenter;
use App\Services\JobPostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobPostController extends Controller
{
    /**
     * @param JobPostService $jobPostService
     */
    public function __construct(protected JobPostService $jobPostService)
    {
    }


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $jobPosts = $this->jobPostService->all(tenant());
        return api([
            'jobs' => (new JobPostPresenter($jobPosts->toArray()['data']))() ?? [],
            'meta' => pagination_meta($jobPosts)
        ])->success(__('response.success'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $jobPostDTO = $this->jobPostService->prepareDtoCreate(tenant(), $request->validated());

            $jobPost = $this->jobPostService->store($jobPostDTO);

            DB::commit();

            return api((new JobPostPresenter($jobPost))())->success(__('jobpost.create.success'));

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
        $jobPost = $this->jobPostService->findByUid(tenant(),$uid);

        if ($jobPost === null) {
            return api()->fails(__('response.fail'));
        }

        return api((new JobPostPresenter($jobPost))())->success(__('response.success'));
    }

    /**
     * @param Request $request
     * @param string $uid
     * @return JsonResponse
     */
    public function update(Request $request, string $uid): JsonResponse
    {
        try {

            if (!tenant()) {
                return api()->fails(__('response.fail'));
            }

            $jobPost = $this->jobPostService->findByUid(tenant(), $uid);

            if ($jobPost === null) {
                return api()->fails(__('response.fail'));
            }

            $categoryDTO = $this->jobPostService->prepareDtoUpdate($request->all(), $jobPost);

            $this->jobPostService->update($categoryDTO, $jobPost);

            return api((new JobPostPresenter($jobPost))())->success(__('jobpost.update.success'));

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

            $jobPost = $this->jobPostService->findByUid(tenant(), $uid);

            if (!$jobPost) {
                return api()->fails(__('response.fail'));
            }

            $jobPost->delete();

            return api((new JobPostPresenter())())->success(__('jobpost.delete.success'));

        } catch (\Exception $e) {
            return api()->fails(__('response.fail'));
        }
    }
}
