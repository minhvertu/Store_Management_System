<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api'); //bắt buộc khi sử dụng phải đăng nhập
    }
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        //
        return response()->json(Product::all());
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
        if ($request->user()->can('create-products')) {
            $product = new Product();
            $product->name = $request->input('name');
            $product->product_code = $request->input('product_code');
            $product->amount = $request->input('amount');
            $product->sales = $request->input('sales');
            $product->import_price = $request->input('import_price');
            $product->sell_price = $request->input('sell_price');
            $product->gender_item_code = $request->input('gender_item_code');
            $product->product_id = $request->input('product_id');
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
        return $product;
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
}
