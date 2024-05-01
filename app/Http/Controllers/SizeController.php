<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function __construct()
    // {
    //     $this->middleware('auth:api'); //bắt buộc khi sử dụng phải đăng nhập
    // }

    public function index()
    {
        //
        return response()->json(Size::all());
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
        if ($request->user()->can('create-sizes')) {
            $size = new Size();
            $size->name = $request->input('name');
            $size->save();

            return response()->json($size);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create size!'
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
        return $size;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size, string $id)
    {
        //
        $size = Size::find($id);
        return response()->json($size);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $Size = Size::find($id);
        $Size->update($request->all());

        return response()->json('Size successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        //
        if ($request->user()->can('delete-sizes')) {
            $size = Size::find($id);
            $size->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete size!'
        ], 200);
    }
}

