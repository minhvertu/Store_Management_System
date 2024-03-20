<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
        return response()->json(Supplier::all());
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
        if ($request->user()->can('create-suppliers')) {
            $supplier = new Supplier();
            $supplier->name = $request->input('name');
            $supplier->phone_number = $request->input('phone_number');
            $supplier->detail = $request->input('detail');
            $supplier->email = $request->input('email');
            $supplier->save();
    
            return response()->json($supplier);
        }
    
        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create supplier!' 
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
        return $supplier;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier, string$id)
    {
        //
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $supplier = supplier::find($id);
        $supplier->update($request->all());
        return response()->json('Supplier successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-suppliers')) {
            $supplier = Supplier::find($id);
            $supplier->delete();
            return response([
                'status' => true,
            ], 200);
        }
    
        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete supplier!' 
        ], 200);
    }
}
