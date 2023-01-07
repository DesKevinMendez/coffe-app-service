<?php

namespace App\Http\Controllers\API\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\CommonResource;
use App\Models\Commerce;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($commerce)
    {
        return CommonResource::collection(
            Order::where('commerce_id', $commerce)->applyPaginate(request())
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Models\Commerce  $commerce
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Commerce $commerce, OrderRequest $request)
    {
        $lastOrder = Order::whereDay('created_at', now()->day)
            ->latest()->where('commerce_id', $commerce->id)->first();

        $newOrder = [
            'commerce_id' => $commerce->id,
            'order' => $lastOrder ? $lastOrder->order + 1 : 1
        ];

        $order = Order::create($newOrder);

        return CommonResource::make($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
