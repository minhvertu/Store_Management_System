<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        //
        $user_permission = UserPermission::with ([ 'user','permission'
        ])->get();
        return response()->json($user_permission);
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
        $user_permission = new UserPermission();
        $user_permission->user_id = $request->input('user_id');
        $user_permission->permission_id = $request->input('permission_id');
        $user_permission->save();

        return response()->json($user_permission);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPermission $userPermissions)
    {
        //
        return $userPermissions;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPermission $userPermissions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserPermission $userPermissions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPermission $userPermissions)
    {
        //
    }
}
