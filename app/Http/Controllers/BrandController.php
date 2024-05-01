<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
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
        return response()->json(Brand::all());

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
        if ($request->user()->can('create-brands')) {
            $brand = new Brand();
            $brand->name = $request->input('name');
            $brand->save();

            return response()->json($brand);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create brand!'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
        return $brand;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand, string $id)
    {
        //
        $brand = Brand::find($id);
        return response()->json($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $brand = Brand::find($id);
        $brand->update($request->all());

        return response()->json('Brand successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-brands')) {
            $brand = Brand::find($id);
            $brand->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete Brand!'
        ], 200);
    }
}

