<?php

namespace App\Http\Controllers\API\Commerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommerceRequest;
use App\Http\Resources\CommonResource;
use App\Models\Commerce;

class CommerceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', new Commerce());
        return CommonResource::collection(
            Commerce::isActive()->applyPaginate(request())
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommerceRequest $request)
    {
        $commerce = new Commerce();
        $this->authorize('create', $commerce);

        return CommonResource::make(
            $commerce::create($request->safe()->toArray())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function show(Commerce $commerce)
    {
        $this->authorize('view', $commerce);
        return CommonResource::make($commerce);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function update(CommerceRequest $request, Commerce $commerce)
    {
        $this->authorize('update', $commerce);
        $commerce->update($request->safe()->toArray());
        return CommonResource::make($commerce);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commerce $commerce)
    {
        $this->authorize('delete', $commerce);
        $commerce->delete();
        return response()->noContent();
    }
}
