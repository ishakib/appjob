<?php

namespace App\Http\Controllers;


use App\Http\Requests\JobUpdateRequest;
use App\Presenter\RiderLocationPresenter;
use App\Presenter\RiderPresenter;
use App\Services\RestaurantService;
use App\Services\RiderService;
use Illuminate\Http\JsonResponse;

class JobsController extends Controller
{

    public function __construct(protected RiderService $riderService, protected RestaurantService $restaurantService)
    {

    }
    /**
     * @param JobUpdateRequest $request
     * @param $uid
     * @return JsonResponse
     */
    public function updateRiderLocation(JobUpdateRequest $request, $uid): JsonResponse
    {
        try {
            $rider = $this->riderService->findByUniqueId($uid,['riderLocation']);

            if (is_null($rider)) {
                return api()->fails(__('response.fail'));
            }

            if($rider->riderLocation){

                $riderDTO = $this->riderService->prepareDtoUpdateRiderLocation($request, $rider, $rider->riderLocation);
                $riderLocation = $this->riderService->updateRiderLocation($riderDTO, $rider->riderLocation);

            }else{

                $riderLocationDTO = $this->riderService->prepareDtoStoreRiderLocation($rider,$request);
                $riderLocation = $this->riderService->storeRiderLocation($riderLocationDTO);
            }

            return api((new RiderLocationPresenter($riderLocation))())->success(__('rider_location.update.success'));

        } catch (\Exception $e) {
            return api()->fails(__('response.fail'));
        }
    }

    /**
     * @return JsonResponse
     */
    public function nearestRiders(): JsonResponse
    {
        $restaurant = $this->restaurantService->findByUniqueId(request()->input('restaurant_id'));

        if (is_null($restaurant)) {
            return api()->fails(__('restaurant_not_fount.fail'));
        }

        $riders = $this->riderService->getNearestRiders($restaurant);

        return api([

            'riders' => (new RiderPresenter($riders->toArray()['data']))() ?? [],
            'meta' => pagination_meta($riders),
        ])->success(__('response.success'));
    }


}
