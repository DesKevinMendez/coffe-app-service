<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionsRequest;
use App\Http\Resources\CommonResource;
use App\Http\Resources\SigleResource;
use App\Models\SpatiePermissions;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return CommonResource::make(SpatiePermissions::create($request->safe()->toArray()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
