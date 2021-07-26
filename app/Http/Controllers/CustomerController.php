<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCustomerRequest;
use App\Http\Requests\RegisterCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\User;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use App\Services\RegisterCustomerService;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Delete Customer
     *
     * @param DeleteCustomerRequest $request
     *
     * @return ApiResponseService
     */
    public function delete(DeleteCustomerRequest $request)
    {

        try {

            $this->authorize('delete_customer');
            $validated = $request->validated();
            Customer::where('id', '=', $validated['id'])->delete();

            return ApiResponseService::make('Cliente apagado com sucesso', 202, ['deleted' => $validated['id']]);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    /**
     * Update Customer data
     *
     * @param UpdateCustomerRequest $request
     * @return ApiResponseService
     */
    public function update(UpdateCustomerRequest $request)
    {

        try {
            $this->authorize('update_customer');
            $validated = $request->validated();

            Customer::where('id', $validated['id'])->update($validated);

            return ApiResponseService::make('Dados atualizados do cliente com sucesso', 200, ['customer' => $validated['id']]);

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    public function show(Customer $customer)
    {

        try {
            $this->authorize('show_customer');
            $responseData = $customer->toArray();
            return ApiResponseService::make('Consulta realizada com sucesso', 200, $responseData);
        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

    /**
     * List all customers
     *
     * @return void
     */
    public function showAll()
    {
        try {
            $this->authorize('show_customer');
            $accountId = Auth::user()->account->id;
            $customers =  Customer::where('account_id',$accountId)->get();


            return ApiResponseService::make('Consulta Realizada com Sucesso!!!',200,$customers->toArray());

        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }

}
