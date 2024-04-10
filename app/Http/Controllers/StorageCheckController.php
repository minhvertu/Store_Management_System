<?php

namespace App\Http\Controllers;

use App\Models\StorageCheck;
use Illuminate\Http\Request;

class StorageCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(StorageCheck $storageCheck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StorageCheck $storageCheck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StorageCheck $storageCheck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StorageCheck $storageCheck)
    {
        //
    }

    public function getProductAmount($shop_id, $product_id)
    {
        $amount = StorageCheck::where('store_id', $shop_id)
            ->where('product_id', $product_id)
            ->sum('amount');

        return response()->json(['amount' => $amount]);
    }
}