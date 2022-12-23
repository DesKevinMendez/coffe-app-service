<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionsRequest;
use App\Http\Resources\CommonResource;
use App\Models\SpatiePermissions;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', new SpatiePermissions());
        return CommonResource::collection(SpatiePermissions::applyPaginate(request()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PermissionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionsRequest $request)
    {
        $this->authorize('create', new SpatiePermissions());
        return CommonResource::make(SpatiePermissions::create($request->safe()->toArray()));
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\SpatiePermissions  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(SpatiePermissions $permission)
    {
        $this->authorize('view', new SpatiePermissions());
        return CommonResource::make($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PermissionsRequest  $request
     * @param  App\Models\SpatiePermissions  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionsRequest $request, SpatiePermissions $permission)
    {
        $this->authorize('update', new SpatiePermissions());
        $permission->update($request->safe()->toArray());
        return CommonResource::make($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\SpatiePermissions  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpatiePermissions $permission)
    {
        $this->authorize('delete', new SpatiePermissions());
        $permission->delete();

        return response()->noContent();
    }
}
