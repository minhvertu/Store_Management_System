<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     */
    
    public function index() {
        
        return response()->json(User::all());
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
        $users = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);
        
        $users->save();
        return response()->json('Update user successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        //
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $users = User::find($id);
        $users->update($request->all());
        return response()->json([
            'user' => $users,
            'User updated!']);
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    public function viewPermission(Request $request) {
        if ($request->user()->can('view-users')) {
            return response()->json(User::all()); 
        } 
        
        return response([
            'status' => false,
            'message' => 'You don\'t have permission to view users!' 
        ], 200);
    }
}
