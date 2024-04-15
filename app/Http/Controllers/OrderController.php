<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
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
        $orders = Order::with(['user', 'order_product.product'])->get();
        foreach ($orders as $order) {
            foreach ($order->order_product as $orderProduct) {
                $product = $orderProduct->product;
                $orderProduct->sell_price = $product->sell_price;
            }
        }

        return response()->json($orders);
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
    $user = $request->user();
    if ($request->user()->can('create-orders')) {
        $order = new Order();
        $order->order_code = $this->generateOrderCode();
        $order->user_id = $user->id;

        // Mảng chứa các trạng thái có thể
        $statuses = ['pending', 'paid', 'sending'];

        // Chọn ngẫu nhiên một trạng thái từ mảng
        $randomStatus = $statuses[array_rand($statuses)];

        $order->status = $randomStatus;
        $order->save();
        
        $totalPrice = 0;

        foreach ($request->input('products') as $product) {
            $orderProduct = new OrderProduct();

            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product['id'];
            $orderProduct->amount = $product['amount'];

            $productSellPrice = Product::find($product['id'])->sell_price;

            $productTotalPrice = $productSellPrice * $orderProduct->amount;
            $totalPrice += $productTotalPrice;
            $order->order_product()->save($orderProduct);
        }
        $order->price = $totalPrice;

        // if ($order->order_product()->exists()) {
        //     $order->status = 'paid';
        // }
        $order->detail = $request->input('detail');
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
        // Tìm đơn hàng cần cập nhật
        $order = Order::find($id);

        // Kiểm tra xem đơn hàng có tồn tại hay không
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->update([
            'detail' => $request->detail,
        ]);

        // Nếu có yêu cầu cập nhật các sản phẩm trong đơn hàng
        if ($request->has('products')) {
            $totalPrice = 0;

            foreach ($request->products as $product) {
                // Tìm hoặc tạo một đối tượng OrderProduct
                $orderProduct = OrderProduct::updateOrCreate(
                    ['order_id' => $order->id, 'product_id' => $product['id']],
                    ['amount' => $product['amount']]
                );

                // Tính lại tổng giá trị của đơn hàng
                $productSellPrice = Product::find($product['id'])->sell_price;
                $productTotalPrice = $productSellPrice * $orderProduct->amount;
                $totalPrice += $productTotalPrice;
            }

            // Cập nhật giá (price) của đơn hàng
            $order->price = $totalPrice;
        }

        // Lưu lại các thay đổi vào đơn hàng
        $order->save();

        // Trả về thông báo về việc cập nhật đơn hàng thành công
        return response()->json(['message' => 'Order successfully updated']);
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

    public function generateOrderCode()
    {
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
