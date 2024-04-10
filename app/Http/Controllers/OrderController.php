<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
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
        $order = Order::with ([ 'user','client',
        ])->get();
        return response()->json($order);
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
            $order->price = $request->input('price');
            $order->detail = $request->input('detail');
            $order->order_code = $this->generateOrderCode();
            $order->client_id = $request->input('client_id');
            $order->user_id = $request->input('user_id');
            $order->status = $request->input('status');
            $order->save();
            
            foreach ($request->input('products') as $product) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $product['id'];
                $orderProduct->amount = $product['amount'];
                $orderProduct->save();
            }
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
            $order = Order::find($id);
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

    public function generateOrderCode() {
        $digits = 3; // Số lượng chữ số
        $letters = 2; // Số lượng chữ cái
    
        $numbers = '';
        for ($i = 0; $i < $digits; $i++) {
            $numbers .= mt_rand(0, 9); // Tạo ngẫu nhiên chữ số từ 0 đến 9
        }
    
        $characters = '';
        $lettersRange = range('A', 'Z'); // Mảng chứa các chữ cái từ A đến Z
        for ($i = 0; $i < $letters; $i++) {
            $characters .= $lettersRange[array_rand($lettersRange)]; // Chọn ngẫu nhiên một chữ cái từ mảng
        }
    
        return 'ORD' . $numbers . $characters;
    }
}
