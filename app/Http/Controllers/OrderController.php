<?php

namespace App\Http\Controllers;

use App\Mail\DemoMail;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSizeAmount;
use App\Models\Storage;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:api'); //bắt buộc khi sử dụng phải đăng nhập
        // $this->middleware('auth:client'); //bắt buộc khi sử dụng phải đăng nhập
    }

    public function index(Request $request)
    {
        // Lấy role_id của người dùng đang đăng nhập
        $roleId = $request->user()->role_id;

        // Khởi tạo truy vấn để lấy các đơn hàng
        $ordersQuery = Order::with(['user', 'order_product.product', 'client']);

        // Kiểm tra vai trò của người dùng
        if ($roleId == 4) {
            // Nếu người dùng có role_id là 4, truy vấn toàn bộ các đơn hàng
            $orders = $ordersQuery->get();
        } else {
            // Nếu người dùng không có role_id là 4, thực hiện các điều kiện lọc theo shop_id
            $shopId = $request->user()->shop_id;

            // Thêm điều kiện lọc theo shop_id nếu có user_id hoặc không có client_id
            $ordersQuery->where(function ($query) use ($shopId) {
                // Nếu có user_id, lọc theo shop_id của user
                $query->where(function ($subQuery) use ($shopId) {
                    $subQuery->whereNotNull('user_id')
                        ->whereHas('user', function ($userQuery) use ($shopId) {
                            $userQuery->where('shop_id', $shopId);
                        });
                });

                // Điều kiện cho các đơn hàng có client_id và không có user_id
                if ($shopId == 2) {
                    $query->orWhere(function ($subQuery) {
                        $subQuery->whereNull('user_id')
                            ->whereNotNull('client_id');
                    });
                }
            });

            // Lấy danh sách các đơn hàng từ truy vấn
            $orders = $ordersQuery->get();
        }

        // Cập nhật sell_price của order_product dựa trên product
        foreach ($orders as $order) {
            foreach ($order->order_product as $orderProduct) {
                $product = $orderProduct->product;
                $orderProduct->sell_price = $product->sell_price;
            }
        }

        // Trả về danh sách các đơn hàng được lọc dưới dạng JSON
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
    // Tạo đơn hàng mới
    $order = new Order();
    $order->order_code = $this->generateOrderCode();

    // Kiểm tra nếu người dùng đã đăng nhập
    if ($request->user()) {
        // Lấy `user_id` từ người dùng đang đăng nhập
        $order->user_id = $request->user()->id;
        // Đặt trạng thái đơn hàng là "paid" cho đơn hàng có `user_id`
        $order->status = 'paid';
    } else {
        // Nếu người dùng không đăng nhập, để `user_id` là null và đặt trạng thái đơn hàng là "shipping"
        $order->user_id = null;
        $order->status = 'shipping';
    }

    $totalPrice = 0;

    // Xử lý các sản phẩm trong đơn hàng
    foreach ($request->input('products') as $product) {
        $orderProduct = new OrderProduct();

        $orderProduct->order_id = $order->id;
        $orderProduct->product_id = $product['id'];
        $orderProduct->amount = $product['amount'];
        $orderProduct->size_id = $product['size_id'];

        // Tìm `storage_id` từ bảng storages dựa trên `product_id`
        $storage = Storage::where('product_id', $product['id'])->first();

        // Nếu trạng thái là "shipping" hoặc "paid", cập nhật số lượng
        if ($order->status === 'shipping' || $order->status === 'paid') {
            if ($storage) {
                $productSizeAmount = ProductSizeAmount::where([
                    ['storage_id', '=', $storage->id],
                    ['size_id', '=', $product['size_id']]
                ])->first();

                if ($productSizeAmount) {
                    $productSizeAmount->amount -= $product['amount'];
                    $productSizeAmount->save();
                }
            }
        }

        // Tính giá sản phẩm và tổng giá
        $productSellPrice = Product::find($product['id'])->sell_price;
        $productTotalPrice = $productSellPrice * $orderProduct->amount;
        $totalPrice += $productTotalPrice;

        // Lưu `OrderProduct`
        $order->order_product()->save($orderProduct);
    }

    // Lưu tổng giá vào đơn hàng
    $order->price = $totalPrice;
    $order->detail = $request->detail;
    $order->phone_number = $request->phone_number;
    $order->client_name = $request->client_name;
    $order->address = $request->address;

    // Lưu đơn hàng
    $order->save();

    // Trả về đơn hàng dưới dạng JSON
    return response()->json($order);

    // Nếu người dùng không có quyền tạo đơn hàng
    // Nếu người dùng không có quyền tạo đơn hàng
    return response([
        'status' => false,
        'message' => 'You don\'t have permission to create Order!'
    ], 404);
}

    public function getTotalOrderPrice()
    {

        $totalOrderPrice = Order::where('status', 'paid','shipping')->sum('price');

        return response()->json(['totalOrderPrice' => $totalOrderPrice]);
    }

    public function getTotalOrder()
    {

        $totalOrder = Order::count();


        return response()->json(['totalOrder' => $totalOrder]);
    }

    public function getTotalShopOrder(Request $request)
{
    // Lấy `shop_id` từ người dùng đang đăng nhập
    $shopId = $request->user()->shop_id;

    // Đếm tổng số đơn hàng theo `shop_id`
    $totalOrder = Order::whereHas('user', function ($query) use ($shopId) {
        $query->where('shop_id', $shopId);
    })->count();

    // Trả về kết quả dưới dạng JSON
    return response()->json(['totalOrder' => $totalOrder]);
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
    // public function update(Request $request, string $id)
    // {
    //     // Tìm đơn hàng cần cập nhật
    //     $order = Order::find($id);

    //     // Kiểm tra xem đơn hàng có tồn tại hay không
    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found'], 404);
    //     }

    //     $order->update([
    //         'detail' => $request->detail,
    //     ]);

    //     // Nếu có yêu cầu cập nhật các sản phẩm trong đơn hàng
    //     if ($request->has('products')) {
    //         $totalPrice = 0;

    //         foreach ($request->products as $product) {
    //             // Tìm hoặc tạo một đối tượng OrderProduct
    //             $orderProduct = OrderProduct::updateOrCreate(
    //                 ['order_id' => $order->id, 'product_id' => $product['id']],
    //                 ['amount' => $product['amount']]
    //             );

    //             // Tính lại tổng giá trị của đơn hàng
    //             $productSellPrice = Product::find($product['id'])->sell_price;
    //             $productTotalPrice = $productSellPrice * $orderProduct->amount;
    //             $totalPrice += $productTotalPrice;
    //         }

    //         // Cập nhật giá (price) của đơn hàng
    //         $order->price = $totalPrice;
    //     }

    //     // Lưu lại các thay đổi vào đơn hàng
    //     $order->save();

    //     // Trả về thông báo về việc cập nhật đơn hàng thành công
    //     return response()->json(['message' => 'Order successfully updated']);
    // }

    public function update(Request $request, string $id)
    {
        //
        $ordert = Order::find($id);
        $ordert->update($request->all());

        return response()->json('Order successfully updated');
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

    public function calculateShopRevenue(Request $request)
{
    // Lấy shop_id từ người dùng đang đăng nhập
    $shopId = $request->user()->shop_id;

    // Nếu người dùng không có shop_id, trả về lỗi
    if (!$shopId) {
        return response()->json(['error' => 'User does not belong to any shop'], 400);
    }

    // Khởi tạo tổng doanh thu
    $totalShopRevenue = 0;

    // Tính tổng doanh thu từ các đơn hàng có user_id trùng với shop_id
    $totalShopRevenue += Order::whereHas('user', function ($query) use ($shopId) {
        $query->where('shop_id', $shopId);
    })
    ->whereIn('status', ['paid', 'shipping'])
    ->sum('price');

    // Nếu shop_id là 2, tính thêm tổng doanh thu từ các đơn hàng trực tuyến (có client_id nhưng không có user_id)
    if ($shopId == 2) {
        $totalShopRevenue += Order::whereNull('user_id') // Chỉ tính các đơn hàng không có user_id
            ->whereNotNull('client_id') // Chỉ tính các đơn hàng có client_id
            ->whereIn('status', ['paid', 'shipping']) // Chỉ tính đơn hàng có trạng thái "paid" hoặc "shipping"
            ->sum('price');
    }

    // Trả về tổng doanh thu của cửa hàng dưới dạng phản hồi JSON
    return response()->json([
        'shop_id' => $shopId,
        'totalShopRevenue' => $totalShopRevenue
    ]);
}

    public function calculateOnlineOrders()
{
    // Tính tổng doanh thu từ các đơn hàng không có `user_id` nhưng có `client_id`
    $totalRevenue = Order::whereNull('user_id') // Chỉ chọn các đơn hàng không có `user_id`
        ->whereNotNull('client_id') // Chỉ chọn các đơn hàng có `client_id`
        ->whereIn('status', ['paid', 'shipping']) // Chỉ tính đơn hàng có trạng thái "paid" hoặc "shipping"
        ->sum('price'); // Tính tổng doanh thu

    // Trả về tổng doanh thu dưới dạng phản hồi JSON
    return response()->json([
        'totalRevenue' => $totalRevenue
    ]);
}


public function calculateMonthlyShopRevenue(Request $request)
{
    // Lấy shop_id từ người dùng đang đăng nhập
    $shopId = $request->user()->shop_id;

    // Nếu người dùng không có shop_id, trả về lỗi
    if (!$shopId) {
        return response()->json(['error' => 'User does not belong to any shop'], 400);
    }

    // Truy vấn doanh thu theo tháng của cửa hàng
    $monthlyShopRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(price) as total_revenue')
        ->where(function ($query) use ($shopId) {
            // Tính doanh thu từ các đơn hàng liên quan đến người dùng (có user_id) với shop_id tương ứng
            $query->whereHas('user', function ($subQuery) use ($shopId) {
                $subQuery->where('shop_id', $shopId);
            });

            // Nếu shop_id là 2, thêm điều kiện tính doanh thu từ các đơn hàng có client_id nhưng không có user_id
            if ($shopId == 2) {
                $query->orWhere(function ($subQuery) {
                    $subQuery->whereNull('user_id')
                             ->whereNotNull('client_id');
                });
            }
        })
        ->whereIn('status', ['paid', 'shipping']) // Chỉ tính đơn hàng có trạng thái "paid" hoặc "shipping"
        ->groupBy('month')
        ->get();

    // Tạo mảng trống với 12 phần tử (từ tháng 1 đến tháng 12)
    $monthlyRevenue = array_fill(0, 12, 0);

    // Điền doanh thu theo tháng vào mảng
    foreach ($monthlyShopRevenue as $item) {
        // Lưu ý rằng `month` là giá trị số của tháng (1 đến 12)
        $monthIndex = $item->month - 1; // Chuyển đổi tháng sang chỉ mục mảng
        $monthlyRevenue[$monthIndex] = $item->total_revenue;
    }

    // Trả về tổng doanh thu theo tháng của cửa hàng dưới dạng phản hồi JSON
    return response()->json([
        'monthlyShopRevenue' => $monthlyRevenue
    ]);
}



}
