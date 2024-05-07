<?php

namespace App\Http\Controllers;

use App\Models\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        //
        return response()->json(Role::all());
    }

    public function show(Role $roles)
    {
        //
        return $roles;
    }

    public function store(Request $request)
    {
        //
        $role = new Role();
        $role->slug = $request->input('slug');
        $role->name = $request->input('name');
        $role->save();

        return response()->json($role);
    }
}
