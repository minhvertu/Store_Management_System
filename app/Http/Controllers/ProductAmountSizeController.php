<?php

namespace App\Http\Controllers;

use App\Models\ProductSizeAmount;
use Illuminate\Http\Request;

class ProductSizeAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $product_size_amount = ProductSizeAmount::with ([ 'storage','size',
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
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductAmountSize $productAmountSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductAmountSize $productAmountSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductAmountSize $productAmountSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAmountSize $productAmountSize)
    {
        //
    }
}
