<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse\ApiResponseErrorService;
use App\Services\ApiResponse\ApiResponseService;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function show(Request $request)
    {
        try {
            $this->authorize('show_all_role');
            $user = $request->user();
            $roles = Role::where([
                ['module', '=', 'invoice'],
                ['account_id', '=', null]])
                ->orWhere('account_id', $user->account->id)
                ->get();
            return ApiResponseService::make('Consulta Realizada com sucesso!!!', 200, $roles->toArray());
        } catch (Exception $e) {
            return ApiResponseErrorService::make($e);
        }
    }
}
