<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware('auth:api'); //bắt buộc khi sử dụng phải đăng nhập
     }

    public function index()
    {
        //
        return response()->json(Order::all());
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
            $order = new Order();
            $order->amount = $request->input('amount');
            $order->price = $request->input('price');
            $order->detail = $request->input('detail');
            $order->order_code = $request->input('order_code');
            $order->client_id = $request->input('client_id');
            $order->user_id = $request->input('user_id');
            $order->save();
            return response()->json($order);
        }
        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create Order!' 
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $order = Order::find($id);
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $order = Order::find($id);
        $order->update($request->all());

        return response()->json('order successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-orders')) {
            $order = order::find($id);
            $order->delete();
            return response([
                'status' => true,
            ], 200);
        }
    
        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete order!' 
        ], 200);
    }
}
