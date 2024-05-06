<?php

namespace App\Http\Controllers;

use App\Models\ProductAmountSize;
use App\Models\ProductSizeAmount;
use App\Models\Storage;
use App\Models\Product;

use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api'); //bắt buộc khi sử dụng phải đăng nhập
    }


    public function index(Request $request)
    {
        //
        $shopId = $request->user()->shop_id;
        $roleId = $request->user()->role_id;
        if ($roleId == '2') {
            $storage = Storage::with ([ 'shop','product', 'product_size_amount'
            ])->get();
            return response()->json($storage);
        } else if ( $roleId !='2') {
            $storage = Storage::with(['shop', 'product', 'product_size_amount'])
            ->where('shop_id', $shopId) // Lọc theo shop_id
            ->get();
        }

        // Lọc dữ liệu theo shop_id
        $storage = Storage::with(['shop', 'product', 'product_size_amount'])
                         ->where('shop_id', $shopId) // Lọc theo shop_id
                         ->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($storage);
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
    // Kiểm tra quyền truy cập
    if ($request->user()->can('create-storages')) {
        $shop = $request->shop_id;
        $product = $request->product_id;

        // Kiểm tra tồn tại của Storage
        $existingStorage = Storage::where('shop_id', $shop)
            ->where('product_id', $product)
            ->first();

        if (!$existingStorage) {
            // Tạo Storage mới
            $storage = new Storage();
            $storage->shop_id = $shop;
            $storage->product_id = $product;
            $storage->save();

            $storage_id = $storage->id; // Lấy ID của storage mới tạo
        } else {
            $storage_id = $existingStorage->id; // Sử dụng ID của storage đã tồn tại
        }

        $size_id = $request->size_id;
        $amount = $request->amount;

        // Lấy sản phẩm theo ID
        $product = Product::find($request->product_id);

        // Tính tổng chi phí nhập hàng
        $totalImportCost = $product->import_price * $amount;

        // Kiểm tra bản ghi ProductSizeAmount đã tồn tại
        $existingProductSizeAmount = ProductSizeAmount::where('storage_id', $storage_id)
            ->where('size_id', $size_id)
            ->first();

        if ($existingProductSizeAmount) {
            // Nếu đã có bản ghi, cập nhật số lượng và thêm tiền nhập hàng
            $existingProductSizeAmount->amount += $amount;
            $existingProductSizeAmount->import_cost += $totalImportCost;
            $existingProductSizeAmount->save();
        } else {
            // Nếu không có bản ghi, tạo mới và lưu số tiền nhập hàng
            $product_size_amount = new ProductSizeAmount();
            $product_size_amount->size_id = $size_id;
            $product_size_amount->storage_id = $storage_id;
            $product_size_amount->amount = $amount;
            $product_size_amount->import_cost = $totalImportCost;
            $product_size_amount->import_code = $this->generateImportCode();
            $product_size_amount->save();
        }

        // Trả về kết quả lưu trữ và tổng chi phí nhập hàng
        return response()->json([
            'storage_id' => $storage_id,
            'total_import_cost' => $totalImportCost
        ]);

    }

    // Trả về thông báo lỗi nếu không có quyền
    return response([
        'status' => false,
        'message' => 'You don\'t have permission to Import Products!'
    ], 404);
}



    /**
     * Display the specified resource.
     */
    public function show(Storage $storage)
    {
        //
        return $storage;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Storage $storage, string $id)
    {
        //
        $storage = Storage::find($id);
        return response()->json($storage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $storage = Storage::find($id);
        $storage->update($request->all());

        return response()->json('Storage successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */



    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-storages')) {
            $storage = Storage::find($id);
            $storage->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete storage!'
        ], 200);
    }

    // public function getProductAmount($shop_id, $product_id)
    // {
    //     $amount = Storage::where('store_id', $shop_id)
    //         ->where('product_id', $product_id)
    //         ->sum('amount');

    //     return response()->json(['amount' => $amount]);
    // }
    public function calculateTotalImportCost(Request $request)
    {

        $totalImportCost = ProductSizeAmount::sum('import_cost');

       
        return response()->json(['totalImportCost' => $totalImportCost]);
    }

    public function generateImportCode()
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

        return 'IMP' . $numbers . $characters;
    }

    public function calculateShopImportCost(Request $request)
    {
        // Lấy shop_id từ người dùng đang đăng nhập
        $shopId = $request->user()->shop_id;

        // Kiểm tra nếu người dùng không có shop_id
        if (!$shopId) {
            return response()->json(['error' => 'User does not belong to any shop'], 400);
        }

        // Truy vấn tổng tiền nhập hàng của cửa hàng bằng cách lấy tổng các cột 'price'
        // trong bảng product_size_amount có storage_id liên kết với shop_id của cửa hàng
        $totalShopImportCost = ProductSizeAmount::whereHas('storage', function ($query) use ($shopId) {
            $query->where('shop_id', $shopId);
        })
        ->sum('import_cost');

        // Trả về tổng tiền nhập hàng của cửa hàng dưới dạng JSON
        return response()->json([
            'shop_id' => $shopId,
            'totalShopImportCost' => $totalShopImportCost
        ]);
    }


    public function calculateMonthlyShopImportCost(Request $request)
{
   
    $shopId = $request->user()->shop_id;

   
    if (!$shopId) {
        return response()->json(['error' => 'User does not belong to any shop'], 400);
    }

    // Truy vấn tổng chi phí nhập hàng theo tháng của cửa hàng
    $monthlyShopImportCost = ProductSizeAmount::selectRaw('MONTH(created_at) as month, SUM(import_cost) as total_import_cost')
        ->whereHas('storage', function ($query) use ($shopId) {
            $query->where('shop_id', $shopId);
        })
        ->groupBy('month')
        ->get();

    // Khởi tạo mảng với 12 phần tử (từ tháng 1 đến tháng 12) với giá trị mặc định là 0
    $monthlyData = array_fill(0, 12, 0);

    // Cập nhật tổng chi phí nhập hàng theo tháng trong mảng
    foreach ($monthlyShopImportCost as $item) {
        // Đảo ngược phần tử của mảng để định dạng dữ liệu theo thứ tự của tháng (0-11)
        $monthlyData[$item->month - 1] = $item->total_import_cost;
    }

  
    return response()->json([
        'monthlyShopImportCost' => $monthlyData,
    ]);
}


}
