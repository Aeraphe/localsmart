<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRepairInvoiceRequest;
use App\Http\Requests\RepairInvoiceRequest;
use App\Http\Requests\ShowRepairInvoiceRequest;
use App\Http\Requests\UpdateRepairInvoiceRequest;
use App\Models\RepairInvoice;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            $validated = $request->validated();
            $request->route('invoice')->update($validated);

            return ApiResponseService::make('Dados atualizados com sucesso', 200, ['id' => $validated['id']]);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }

    }

    /**
     * Delete Repair Invoice
     *
     * @param DeleteRepairInvoiceRequest $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function delete(DeleteRepairInvoiceRequest $request)
    {
        try {

            $this->authorize('delete_repair_invoice');

            $validated = $request->validated();
            $request->route('invoice')->delete();

            return ApiResponseService::make('Ordem de serviço apagada com sucesso', 200, ['id' => $validated['id']]);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }

    }

    /**
     * Show Repair Invoice
     *
     * @param ShowRepairInvoiceRequest $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function show(ShowRepairInvoiceRequest $request)
    {
        try {

            $this->authorize('show_repair_invoice');
            $invoice = $request->route('invoice')->with('status', 'equipament')->first();
            $invoice->equipament->conditions;
            $invoice->equipament->inspetions;
            return ApiResponseService::make('Operação realizada com sucesso!!!', 200, $invoice->toArray());

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }

    }

    /**
     * Show Repair Invoice
     *
     * @param Request $request
     * @return ApiResponseService | ApiResponseErrorService
     */
    public function showAll(Request $request)
    {
        try {

            $this->authorize('show_all_repair_invoice');
            $store = Auth::user()->account->stores()->where('id', $request->route('id'))->first();

            $invoices = $store->repairInvoice()->with('status', 'conditions.equipament','inspections.equipament')->get();

            return ApiResponseService::make('Operação realizada com sucesso!!!', 200, $invoices->toArray());

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }

    }

}
