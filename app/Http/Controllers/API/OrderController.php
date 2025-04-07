<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $orders = $user->orders;

        return response()->json([
           "data" => OrderResource::collection($orders),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $user = auth()->user();
        if($user->orders()->where('product_id', $product->id)->first()) return $this->errors(code: 403, message: 'Forbidden for you');

        $response = Http::post('https://testapi.buymysite.ru/api/payment', [
            "price" => $product->price,
            "webhook_url" => url('/payment-webhook')
        ]);

        Order::create([
            "user_id" => auth()->id(),
            "product_id" => $product->id,
            "pay_url" => $response['pay_url'],
            "order_id" => $response['order_id']
        ]);

        return response()->json([
          "pay_url" => $response['pay_url']
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->firstOrFail();

        $order->update(["status" => $request->status]);

        return response()->json('', 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
