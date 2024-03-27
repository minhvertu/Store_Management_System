<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        return response()->json(Category::all());
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
        if ($request->user()->can('create-categories')) {
            $category = new Category();
            $category->name = $request->input('name');
            $category->save();
    
            return response()->json($category);
        }
    
        return response([
            'status' => false,
            'message' => 'You don\'t have permission to create category!' 
        ], 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category, string $id)
    {
        //
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $category = Category::find($id);
        $category->update($request->all());

        return response()->json('Category successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-categories')) {
            $category = Category::find($id);
            $category->delete();
            return response([
                'status' => true,
            ], 200);
        }
    
        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete category!' 
        ], 200);
    }
}
