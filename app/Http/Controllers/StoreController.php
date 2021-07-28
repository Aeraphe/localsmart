<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function showAll()
    {
        try {
            $this->authorize('show_all_store');
            $user = Auth::user();
            $storeResponseData = $user->account->stores->toArray();
            return ApiResponseService::make('Consulta realizada com sucesso', 200, $storeResponseData);
        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }
}
