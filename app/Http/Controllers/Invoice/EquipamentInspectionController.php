<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\CreateEquipamentInspectionRequest;
use App\Http\Requests\Invoice\DeleteEquipamentInspectionRequest;
use App\Models\InvoiceEquipamemtInspection;
use App\Models\RepairInvoice;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Http\Request;

class EquipamentInspectionController extends Controller
{
    /**
     * Create equipament Inspection
     *
     * @param CreateEquipamentInspectionRequest $request
     * @return void
     */
    public function create(CreateEquipamentInspectionRequest $request)
    {
        try {

            $this->authorize('create_equipament_inspection');
            $validated = $request->validated();

            $invoice = RepairInvoice::find($validated['repair_invoice_id']);
            $invoice->addEquipamentInspections($validated);

            return ApiResponseService::make('Nova Inspeção Cadastrada com sucesso!!!', 200, $validated);

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }

    /**
     * Delete equipament Inspection
     *
     * @param DeleteEquipamentInspectionRequest $request
     * @return void
     */
    public function delete(DeleteEquipamentInspectionRequest $request)
    {
        try {

            $this->authorize('delete_equipament_inspection');
            $validated = $request->validated();

            InvoiceEquipamemtInspection::find($validated['id'])->delete();

            return ApiResponseService::make('Inspeção Apagada com sucesso!!!', 200, $validated);

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }

}
