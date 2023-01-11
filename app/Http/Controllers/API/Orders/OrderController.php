<?php

namespace App\Http\Controllers\API\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\CommonResource;
use App\Models\Commerce;
use App\Models\Order;
use App\Models\Product;
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
        $productsIds = $request->safe()->toArray();
        $lastOrder = Order::whereDay('created_at', now()->day)
            ->latest()->where('commerce_id', $commerce->id)->first();

        $newOrder = [
            'commerce_id' => $commerce->id,
            'order' => $lastOrder ? $lastOrder->order + 1 : 1
        ];

        $order = Order::create($newOrder);

        $order->products()->attach([...$productsIds['products']]);

        return CommonResource::make($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $commerce
     * @param  int  $order
     * @return \Illuminate\Http\Response
     */
    public function show($commerce, $order)
    {
        $orderToLoad = Order::with('products')
            ->where('commerce_id', $commerce)->find($order);

        if (is_null($orderToLoad)) {
            abort(404, 'not found');
        }

        return CommonResource::make($orderToLoad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $commerce
     * @param  int $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $commerce, $order)
    {
        $productsIds = $request->safe()->toArray();

        $orderToUpdate = Order::where('commerce_id', $commerce)->find($order);
        if (is_null($orderToUpdate)) {
            abort(404);
        }

        $sumOrPrice = Product::select('price')
            ->whereIn('id', $productsIds['products'])->get()
            ->pluck('price')->sum();

        $orderToUpdate->total = $sumOrPrice;
        $orderToUpdate->update();
        $orderToUpdate->products()->sync($productsIds['products']);

        $orderToUpdate->load('products');

        return CommonResource::make($orderToUpdate);
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
