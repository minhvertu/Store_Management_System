<?php

namespace App\Http\Controllers;

use App\Models\ProductSizeAmount;
use App\Models\Storage;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSizeAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api'); // Loại trừ index và show khỏi yêu cầu xác thực
    }

    public function index()
    {
        //
        $product_size_amount = ProductSizeAmount::with ([ 'storage','size','product'
        ])->get();
        return response()->json($product_size_amount);
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
        if ($request->user()->can('create-storages')) {
            $storage = $request->storage_id;
            $product = $request->product_id;
            $size = $request->size_id;
            $amount = $request->amount;

            // Tìm hoặc tạo mới ProductSizeAmount
            $existingStorage = Storage::where('storage_id', $storage)
                ->where('product_id', $product)
                ->first();

            if (!$existingStorage) {
                $storage = new Storage();
                $storage->storage_id= $storage;
                $storage->product_id= $product;
                $storage->save();
            }

            $product_size_amount = ProductSizeAmount::where('storage_id', $storage)
                ->where('size_id', $size)
                ->first();

            if ($product_size_amount) {
                // Nếu đã có bản ghi tồn tại, cập nhật amount bằng cách cộng thêm vào
                $product_size_amount->amount += $amount;
                $product_size_amount->save();
            } else {
                // Nếu không, tạo mới bản ghi
                $product_size_amount = new ProductSizeAmount();
                $product_size_amount->storage_id = $storage;
                $product_size_amount->size_id = $size;
                $product_size_amount->amount = $amount;
                $product_size_amount->save();
            }

            // Trả về thông tin
            return response()->json($shop);
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
    public function show(ProductSizeAmount $productAmountSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSizeAmount $productAmountSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSizeAmount $productAmountSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSizeAmount $productAmountSize)
    {
        //
    }

    public function getProductSizes(Request $request)
    {
        $productId = $request->input('id');

        // Truy vấn database để lấy danh sách các size có sẵn cho sản phẩm
        $availableSizes = ProductSizeAmount::whereHas('storage.product', function ($query) use ($productId) {
            $query->where('id', $productId);
        })->with('size')->get();

        // Trả về danh sách các size có sẵn
        return response()->json(['sizes' => $availableSizes]);
    }

    public function getProductSizeAmountByShop(Request $request)
    {
        // Lấy role_id từ người dùng đang đăng nhập
        $roleId = $request->user()->role_id;

        // Khởi tạo biến để lưu danh sách sản phẩm
        $productSizeAmounts = null;

        // Kiểm tra role_id của người dùng
        if ($roleId == 4 || $roleId == 5) {
            // Nếu role_id là 4 hoặc 5, lấy tất cả sản phẩm mà không cần xét shop_id
            $productSizeAmounts = ProductSizeAmount::with(['storage', 'size'])->get();
        } else {
            // Nếu role_id không phải là 4 hoặc 5, lọc các sản phẩm theo shop_id
            $shopId = $request->user()->shop_id;
            $productSizeAmounts = ProductSizeAmount::whereHas('storage', function ($query) use ($shopId) {
                $query->where('shop_id', $shopId);
            })->with(['storage', 'size'])->get();
        }

        // Trả về danh sách sản phẩm
        return response()->json($productSizeAmounts);
    }

}
