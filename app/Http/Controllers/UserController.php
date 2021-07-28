<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowUserRequest;
use App\Models\User;
use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;

class UserController extends Controller
{

    /**
     * Show user
     *
     * @param ShowUserRequest $request
     * @return void
     */
    public function show(ShowUserRequest $request)
    {
        try {
            $this->authorize('show_user');
            $user = User::find($request->route('id'));

            return ApiResponseService::make('Consulta Realizada com sucesso!!!', '200', $user->toArray());
        } catch (\Throwable$th) {
            return ApiResponseErrorService::make($th);
        }
    }




}
