<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\DescriptionImage;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
class ProductController extends Controller
{

    public function __construct()
{
    $this->middleware('auth:api')->except(['index', 'show']); // Loại trừ index và show khỏi yêu cầu xác thực
}

    


    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        $product = Product::with ([ 'brand','category', 'descriptionImages'
        ])->get();
        // return response()->json([
        //     "id" => $product->id,
        //     "name" => $product->name,
        //     "product_code" => $product->product_code,
        //     "import_price" => $product->import_price,
        //     "sell_price" => $product->sell_price,
        //     "gender_item_code" => $product->gender_item_code,
        //     "brand_id" => $product->brand_id,
        //     "brand_name" => $product->brand->name,
        //     "category_id" => $product->category_id,
        //     "category_name" => $product->category->name,
        //     "image" => $product->image,
        //     "size" => $product->size,
        // ]);
        return response()->json($product);
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
    if ($request->user()->can('create-products')) {
        // Kiểm tra và xác nhận hình ảnh được gửi lên
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'gender_item_code' => 'required',
            'import_price' => 'required',
            'sell_price' => 'required',
            'detail' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
        ]);

        // Xử lý tải lên ảnh và lưu đường dẫn vào biến $path
        $image = $request->file('image');
        $file_name = time() . '_' . $image->getClientOriginalName();
        $path = $request->file('image')->storeAs('products', $file_name, 'public');

        // Tạo mới sản phẩm và gán đường dẫn ảnh
        $product = new Product();
        $product->name = $request->input('name');
        $product->product_code = $this->generateProductCode();
        $product->gender_item_code = $request->input('gender_item_code');
        $product->import_price = $request->input('import_price');
        $product->detail = $request->input('detail');
        $product->sell_price = $request->input('sell_price');

        $product->brand_id = $request->input('brand_id');
        $product->category_id = $request->input('category_id');
        $product->image = $path; // Lưu đường dẫn ảnh vào cơ sở dữ liệu
        $product->save();

        return response()->json($product);
    }

    return response([
        'status' => false,
        'message' => 'You don\'t have permission to create Product!'
    ], 404);
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        $product->load('category', 'brand');

    // Trả về product kèm theo thông tin category.name và brand.name
    return response()->json([
        'product' => $product,
        'id'=>$product->id,
        'image'=>$product->image,
        'name' =>$product->name,
        'detail' =>$product->detail,
        'sell_price' =>$product->sell_price,
        'category_name' => $product->category->name, // Lấy tên của danh mục
        'brand_name' => $product->brand->name, // Lấy tên của thương hiệu
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json('Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-products')) {
            $product = Product::find($id);
            $product->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete Product!'
        ], 200);
    }



    public function get_product_data()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function uploadProductImage(Request $request, Product $product)
    {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->file('image')) {
        $image = $request->file('image');
        $file_name = time() . '_' . $image->getClientOriginalName();
        $path = $request->file('image')->storeAs('products', $file_name, 'public');

        // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
        $product->update(['image' => $path]);

        return response()->json(['image' => $path]);
    }

    return response()->json(['error' => 'Failed to upload image.']);
}
public function generateProductCode() {
    $digits = 4; // Số lượng chữ số
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

    return 'PROD' . $numbers . $characters;
}

public function uploadDescriptionImages(Request $request)
{
    // Nhận dữ liệu từ request
    $productId = $request->input('product_id');
    $images = $request->file('images');

    // Xử lý từng tệp hình ảnh
    foreach ($images as $image) {
        // Lấy tên tệp ban đầu và tạo tên tệp mới với timestamp để tránh trùng lặp
        $fileName = time() . '_' . $image->getClientOriginalName();

        // Lưu hình ảnh vào thư mục 'description_images' trong disk 'public'
        $path = $image->storeAs('description_images', $fileName, 'public');

        // Tạo bản ghi mới trong bảng 'description_images'
        DescriptionImage::create([
            'image' => $path,
            'product_id' => $productId, // Sử dụng product_id từ request
        ]);
    }

    // Trả về phản hồi JSON cho biết thành công
    return response()->json(['message' => 'Images uploaded successfully'], 200);
}


}
