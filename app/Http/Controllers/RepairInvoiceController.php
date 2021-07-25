<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepairInvoiceRequest;
use App\Models\RepairInvoice;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;

class RepairInvoiceController extends Controller
{
    public function create(RepairInvoiceRequest $request)
    {
        try {
            $this->authorize('create_invoice');

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

}
