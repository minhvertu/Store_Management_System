<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
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


        if ($roleId == 4) {
            return response()->json(Shop::all());
        } else if ($roleId != '4') {

        $shops = Shop::where('id', $shopId)->get();
        }

        return response()->json($shops);
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
        if ($request->user()->can('create-shops')) {
            $shop = new Shop();
            $shop->name = $request->input('name');
            $shop->phone_number = $request->input('phone_number');
            $shop->address = $request->input('address');
            $shop->save();

            return response()->json($shop);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create shop!'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
        return $shop;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop, string $id)
    {
        //
        $shop = Shop::find($id);
        return response()->json($shop);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $shop = Shop::find($id);
        $shop->update($request->all());

        return response()->json('Shop successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-shops')) {
            $shop = Shop::find($id);
            $shop->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete shop!'
        ], 200);
    }
}
