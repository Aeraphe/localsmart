<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\CreateRepairStatus;
use App\Http\Requests\Invoice\CreateRepairStatusRequest;
use App\Http\Requests\Invoice\DeleteRepairStatusRequest;
use App\Http\Requests\Invoice\UpdateRepairStatusRequest;
use App\Models\RepairInvoiceStatus;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Http\Request;

class RepairStatusController extends Controller
{

    /**
     * Show Invoice Status
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request)
    {
        try {

            $this->authorize('show_repair_invoice_status');
            $id = $request->route('id');

            $status = RepairInvoiceStatus::where('repair_invoice_id', $id)->get();

            return ApiResponseService::make('Consulta realizada com sucesso!!!', 200, $status->toArray());

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }

    /**
     * Create Invoice Status
     *
     * @param CreateRepairStatus $request
     * @return void
     */
    public function create(CreateRepairStatusRequest $request)
    {
        try {

            $this->authorize('create_repair_invoice_status');
            $id = $request->get('repair_invoice_id');

            $status = RepairInvoiceStatus::where('repair_invoice_id', $id)->create($request->validated());

            return ApiResponseService::make('Status criado com sucesso!!!', 200, $status->toArray());

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }

    /**
     * Delete Invoice Status
     *
     * @param DeleteRepairStatusRequest $request
     * @return void
     */
    public function delete(DeleteRepairStatusRequest $request)
    {
        try {

            $this->authorize('delete_repair_invoice_status');
            $id = $request->get('id');

            RepairInvoiceStatus::where('id', $id)->delete();

            return ApiResponseService::make('Status apagado com sucesso!!!', 200, $request->validated());

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }

    /**
     * Update Invoice Status
     *
     * @param UpdateRepairStatusRequest $request
     * @return void
     */
    public function update(UpdateRepairStatusRequest $request)
    {
        try {

            $this->authorize('update_repair_invoice_status');
            $id = $request->get('id');
            $validated = $request->validated();
            RepairInvoiceStatus::where('id', $id)->update($validated);

            return ApiResponseService::make('Status atualizado com sucesso!!!', 200, $validated);

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }
}
