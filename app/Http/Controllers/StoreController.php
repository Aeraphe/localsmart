<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStoreRequest;
use App\Http\Requests\Store\ShowStoreRequest;
use App\Models\Store;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function showAll()
    {
        try {
            $this->authorize('show_all_store');
            $user = Auth::user();
            $storeResponseData = $user->account->stores->toArray();
            return ApiResponseService::make('Consulta realizada com sucesso', 200, $storeResponseData);
        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    /**
     * Show Store
     *
     * @param ShowStoreRequest $request
     * @return void
     */
    public function show(ShowStoreRequest $request)
    {
        try {
            $this->authorize('show_store');

            $storeId = $request->route('id');
            $storeResponseData = Store::find($storeId)->toArray();

            return ApiResponseService::make('Consulta realizada com sucesso', 200, $storeResponseData);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }

    /**
     * Create Store
     *
     * @param CreateStoreRequest $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function create(CreateStoreRequest $request)
    {
        try {
            $this->authorize('create_store');

            $validated = $request->validated();

            $account = Auth::user()->account;
            $validated['account_id'] = $account->id;

            $storeResponseData = Store::create($validated);

            return ApiResponseService::make('Consulta realizada com sucesso', 200, $storeResponseData->toArray());

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }
}
