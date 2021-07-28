<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\RepairInvoice;
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
 
            $status  =  RepairInvoiceStatus::where('repair_invoice_id',$id )->get();
         
            return ApiResponseService::make('Consulta realizada com sucesso!!!', 200, $status->toArray());

        } catch (Exception $th) {

            return ApiResponseErrorService::make($th);

        }
    }
}
