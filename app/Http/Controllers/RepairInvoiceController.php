<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepairInvoiceRequest;
use App\Http\Requests\UpdateRepairInvoiceRequest;
use App\Models\RepairInvoice;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;

class RepairInvoiceController extends Controller
{
    public function create(RepairInvoiceRequest $request)
    {
        try {
            $this->authorize('create_repair_invoice');

            $validated = $request->validated();

            $dataInvoice = [
                'store_id' => $validated['store_id'],
                'equipament_id' => $validated['equipament_id'],
                'fail_description' => $validated['fail_description'],
                'budget' => $validated['budget'],
            ];

            $invoice = RepairInvoice::create($dataInvoice);
            $invoice->addEquipamentConditions($validated['conditions']);
            $invoice->addEquipamentInspections($validated['inspections']);
            $invoice->status()->create(['description' => 'Primeiro status', 'status' => 1]);

            return ApiResponseService::make('Ordem de Serviço criada com sucesso!!!', 200, ['id' => $invoice->id]);

        } catch (Exception $e) {
            if ($invoice) {$invoice->delete();};
            return ApiResponseErrorService::make($e);
        }
    }
    /**
     * Update Repair Invoice
     *
     * @param UpdateRepairInvoiceRequest $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function update(UpdateRepairInvoiceRequest $request)
    {
        try {
            
            $this->authorize('edit_repair_invoice');
            
            $validated= $request->validated();
            $request->route('invoice')->update($validated);

            return ApiResponseService::make('Dados atualizados com sucesso', 200, ['id' => $validated['id']]);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }

    }

}
