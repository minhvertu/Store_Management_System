<?php

namespace App\Http\Controllers;

use App\Models\Permission;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        //
        return response()->json(Permission::all());
    }

    public function show(Permission $permissions)
    {
        //
        return $permissions;
    }

    public function store(Request $request)
    {
        //
        $permission = new Permission();
        $permission->slug = $request->input('slug');
        $permission->name = $request->input('name');
        $permission->save();

        return response()->json($permission);
    }
}
