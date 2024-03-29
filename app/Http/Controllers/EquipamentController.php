<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCustomerEquipamentRequest;
use App\Http\Requests\EditCustomerEquipamentRequest;
use App\Http\Requests\GetCustomerEquipamentRequest;
use App\Models\Customer;
use App\Models\Equipament;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipamentController extends Controller
{
    public function create(Request $request)
    {

        try {
            $this->authorize('create_equipament');

            $validated = $request->validate([
                'name' => 'required',
                'customer_id' => 'required',
                'gadget_id' => 'nullable',
            ]);

            $equipament = Equipament::create($validated);

            return ApiResponseService::make('Equipamento cadastrado com sucesso', 200, ['name' => $equipament->name]);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);
        }
    }

    /**
     * Get customer equipament
     *
     * @param Request $request
     * @return void
     */
    public function show(GetCustomerEquipamentRequest $request)
    {
        try {
            $this->authorize('show_equipament');

            $equipament = $request->route('equipament')->toArray();
            return ApiResponseService::make('Consulta Realizada com sucesso!!', 200, $equipament);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    /**
     * Get customer equipament
     *
     * @param Request $request
     * @return void
     */
    public function showAll(Request $request)
    {
        try {
            $this->authorize('show_all_equipament');

            $accountId = Auth::user()->account->id;
            $customer = Customer::where('id', $request->route('customer'))->where('account_id', $accountId)->first();
            $equipaments = $customer->equipaments;

            return ApiResponseService::make('Consulta Realizada com sucesso!!', 200, $equipaments->toArray());

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }

    /**
     * Edit customer equipament
     *
     * @param EditCustomerEquipamentRequest $request
     * s
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function update(EditCustomerEquipamentRequest $request)
    {
        try {

            $this->authorize('update_equipament');

            $validated = $request->validated();

            Equipament::where('id', $validated['id'])->update($validated);

            return ApiResponseService::make(
                'Atualização realizada com sucesso!!!',
                200,
                ['id' => $validated['id']]
            );

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }

    /**
     * Delete customer equipament
     *
     * @param DeleteCustomerEquipamentRequest $request
     * s
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function delete(DeleteCustomerEquipamentRequest $request)
    {
        try {

            $this->authorize('delete_equipament');

            $validated = $request->validated();

            Equipament::where('id', $validated['id'])->delete();

            return ApiResponseService::make(
                'Equipamento apagado com sucesso!!!',
                200,
                ['id' => $validated['id']]
            );

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);

        }
    }
}
