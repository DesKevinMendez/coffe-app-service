<?php

namespace App\Http\Controllers\API\Roles;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesWithPermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Roles $role)
    {
        $this->authorize('viewAny', new Roles());
        return CommonResource::make($role->load('permissions'));
    }
}
