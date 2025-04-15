<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateCreateRequest;
use App\Http\Requests\CandidateUpdateRequest;
use App\Presenter\CandidatePresenter;
use App\Services\CandidateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    /**
     * @param CandidateService $candidateService
     */
    public function __construct(protected CandidateService $candidateService)
    {
    }


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $candidates = $this->candidateService->all(tenant());
        return api([
            'jobs' => (new CandidatePresenter($candidates->toArray()['data']))() ?? [],
            'meta' => pagination_meta($candidates)
        ])->success(__('response.success'));
    }

    /**
     * @param CandidateCreateRequest $request
     * @return JsonResponse
     */
    public function store(CandidateCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $candidateDTO = $this->candidateService->prepareDtoCreate(tenant(), $request->validated());

            $candidate = $this->candidateService->store($candidateDTO);

            DB::commit();

            return api((new CandidatePresenter($candidate))())->success(__('candidate.create.success'));

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
        $candidate = $this->candidateService->findByUid(tenant(),$uid);

        if ($candidate === null) {
            return api()->fails(__('response.fail'));
        }

        return api((new CandidatePresenter($candidate))())->success(__('response.success'));
    }

    /**
     * @param CandidateUpdateRequest $request
     * @param string $uid
     * @return JsonResponse
     */
    public function update(CandidateUpdateRequest $request, string $uid): JsonResponse
    {
        try {

            if (!tenant()) {
                return api()->fails(__('response.fail'));
            }

            $candidate = $this->candidateService->findByUid(tenant(), $uid);

            if ($candidate === null) {
                return api()->fails(__('response.fail'));
            }

            $categoryDTO = $this->candidateService->prepareDtoUpdate($request->all(), $candidate);

            $this->candidateService->update($categoryDTO, $candidate);

            return api((new CandidatePresenter($candidate))())->success(__('candidate.update.success'));

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

            $candidate = $this->candidateService->findByUid(tenant(), $uid);

            if (!$candidate) {
                return api()->fails(__('response.fail'));
            }

            $candidate->delete();

            return api((new CandidatePresenter())())->success(__('candidate.delete.success'));

        } catch (\Exception $e) {
            return api()->fails(__('response.fail'));
        }
    }
}
