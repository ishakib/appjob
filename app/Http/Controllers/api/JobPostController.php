<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Presenter\JobPostPresenter;
use App\Services\JobPostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @return void
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPost $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {
        //
    }
}
