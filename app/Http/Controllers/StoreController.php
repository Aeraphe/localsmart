<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStoreRequest;
use App\Http\Requests\Store\ShowStoreRequest;
use App\Http\Requests\Store\SignRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Http\Request;
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

    /**
     * Update Store
     *
     * @param UpdateStoreRequest $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function update(UpdateStoreRequest $request)
    {
        try {
            $this->authorize('update_store');

            $validated = $request->validated();

            Store::where('id', $validated['id'])->update($validated);

            return ApiResponseService::make('Atualizada com sucesso', 200, ['id' => $validated['id']]);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }

    /**
     * Delete Store
     *
     * @param Request $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function delete(Request $request)
    {
        try {
            $this->authorize('delete_store');

            $validated = $request->validate(['id' => ['required', 'numeric']]);

            $store = Auth::user()->account->stores()->where('id', $validated['id'])->first();

            $store->delete();

            return ApiResponseService::make('Loja apagada com sucesso', 200, ['id' => $validated['id']]);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }

    public function sign(SignRequest $request)
    {
        try {
            $this->authorize('sign_store');
            $validated = $request->validated();

            $storeId = $validated['store_id'];
            $employeeId = $validated['employee_id'];

            $store = Store::find($storeId);
            $store->employees()->attach($employeeId);
            $response = [
                'store_id' => $storeId,
                'employee_id' => $employeeId,
            ];
            return ApiResponseService::make('Acesso Liberado a Loja', 200, $response);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    public function unsign(SignRequest $request)
    {
        try {
            $this->authorize('unsign_store');
            $validated = $request->validated();

            $storeId = $validated['store_id'];
            $employeeId = $validated['employee_id'];

            $store = Store::find($storeId);
            $store->employees()->detach($employeeId);
            $response = [
                'store_id' => $storeId,
                'employee_id' => $employeeId,
            ];
            return ApiResponseService::make('Acesso do Funcionárioa a Loja Cancelado', 200, $response);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }
}
