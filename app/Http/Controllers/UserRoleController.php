<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
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
        $user_role = UserRole::with ([ 'user','role'
        ])->get();
        return response()->json($user_role);
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
        $user_role = new UserRole();
        $user_role->user_id = $request->input('user_id');
        $user_role->role_id = $request->input('role_id');
        $user_role->save();

        return response()->json($user_role);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRole $userRole)
    {
        //
        return $userRole;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRole $userRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $roleId)
    {
        try {
            // Tìm và xóa user permission
            UserRole::where('user_id', $userId)->where('role_id', $roleId)->delete();

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred while deleting user role.'], 500);
        }
    }

    public function update(Request $request)
{
    $userId = $request->input('user_id');
    $roleId = $request->input('role_id');

    try {
        // Cập nhật role_id chỉ cho user role tương ứng
        UserRole::where('user_id', $userId)->update(['role_id' => $roleId]);

        return response()->json(['status' => true, 'message' => 'User Role updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => false, 'message' => 'An error occurred while updating user role.'], 500);
    }
}



}
