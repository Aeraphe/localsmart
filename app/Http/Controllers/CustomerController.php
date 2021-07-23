<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCustomerRequest;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use App\Services\RegisterCustomerService;
use Exception;

class CustomerController extends Controller
{
    /**
     * Create customer
     *
     * @param RegisterCustomerRequest $request
     * @return void
     */
    public function create(RegisterCustomerRequest $request)
    {
        try {
            $data = $request->validated();

            $customer = RegisterCustomerService::create($data);
            
            $response = ['name' => $customer->name];
            
            return ApiResponseService::make('Cliente Cadastrado com sucesso', 200, $response);

        } catch (Exception $e) {

            return ApiResponseErrorService::make($e);
        }
    }
}
