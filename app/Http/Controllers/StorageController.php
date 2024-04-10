<?php

namespace App\Http\Controllers;

use App\Models\Storage;
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
        $storage = Storage::with ([ 'shop','product',
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
        //
        if ($request->user()->can('create-storages')) {
            $request->validate([
                'amount' => 'required',
                'shop_id' => 'required',
                'product_id' => 'required',
            ]);

            $storage = new Storage();
            $storage->amount= $request->input('amount');
            $storage->shop_id = $request->input('shop_id');
            $storage->product_id = $request->input('product_id');
            $storage->save();

            return response()->json($storage);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create storage!'
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
}
