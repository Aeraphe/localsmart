<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCustomerEquipamentRequest;
use App\Models\Customer;
use App\Models\Equipament;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Http\Request;

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
}
