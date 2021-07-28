<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\CreateEquipamentConditionRequest;
use App\Http\Requests\Invoice\DeleteEquipamentConditionRequest;
use App\Models\InvoiceEquipamentCondition;
use App\Models\RepairInvoice;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;

class InvoiceEquipamentConditionController extends Controller
{
    /**
     * Create equipament Condition
     *
     * @param CreateEquipamentConditionRequest $request
     * @return void
     */
    public function create(CreateEquipamentConditionRequest $request)
    {
        try {

            $this->authorize('create_equipament_condition');
            $validated = $request->validated();

            $invoice = RepairInvoice::find($validated['repair_invoice_id']);
            $invoice->addEquipamentConditions($validated);

            return ApiResponseService::make('Nova Condição Cadastrada com sucesso!!!', 200, $validated);

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }

    /**
     * Delete equipament Condition
     *
     * @param DeleteEquipamentConditionRequest $request
     * @return void
     */
    public function delete(DeleteEquipamentConditionRequest $request)
    {
        try {

            $this->authorize('delete_equipament_condition');
            $validated = $request->validated();

            InvoiceEquipamentCondition::find($validated['id'])->delete();

            return ApiResponseService::make('Apagada com sucesso!!!', 200, $validated);

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }
}
