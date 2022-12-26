<?php

namespace App\Http\Controllers\API\Roles;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', new Roles());

        return CommonResource::collection(Roles::applyPaginate(request()));
    }
}
