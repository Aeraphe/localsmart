<?php

namespace App\Http\Controllers;

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
}
