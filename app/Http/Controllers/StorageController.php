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

    public function index()
    {
        //
        $storage = Storage::with ([ 'shop','product', 'product_size_amount'
        ])->get();
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
            $product_size_amount->import_code = $this->generateImportCode();
            $product_size_amount->import_cost = $totalImportCost;
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
        // Truy vấn để lấy tổng chi phí nhập hàng (import_cost) từ bảng ProductSizeAmount
        $totalImportCost = ProductSizeAmount::sum('import_cost');

        // Trả về tổng chi phí nhập hàng dưới dạng JSON
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



}
