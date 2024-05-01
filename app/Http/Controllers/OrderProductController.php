<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function __construct()
    // {
    //     $this->middleware('auth:api'); //bắt buộc khi sử dụng phải đăng nhập
    // }

    public function index()
    {
        //
        $order_product = OrderProduct::with ([ 'product','order',
        ])->get();
        return response()->json($order_product);
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
    public function store(Request $request)
    {
        //
        if ($request->user()->can('create-orders')) {
            $order_product = new OrderProduct();
            $order_product->amount = $request->input('amount');
            $order_product->product_id = $request->input('product_id');
            $order_product->order_id = $request->input('order_id');
            $order_product->save();
            return response()->json($order_product);
        }
        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create Order!'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProduct $order_product)
    {
        //
        return $order_product;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $order_product = OrderProduct::find($id);
        return response()->json($order_product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $order_product = OrderProduct::find($id);
        $order_product->update($request->all());

        return response()->json('order_product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-orders')) {
            $order_product = OrderProduct::find($id);
            $order_product->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete order_product!'
        ], 200);
    }



}
