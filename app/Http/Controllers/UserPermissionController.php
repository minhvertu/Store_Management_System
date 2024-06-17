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
    public function update(Request $request)
    {
        // Lấy giá trị user_id, permission_id và new_permission_id từ request input
        $userId = $request->input('user_id');
        $permissionId = $request->input('permission_id');
        $newPermissionId = $request->input('new_permission_id');

        // Kiểm tra xem user_id, permission_id và new_permission_id có hợp lệ không
        if (!$userId || !$permissionId || !$newPermissionId) {
            return response()->json(['message' => 'Thiếu thông tin'], 400);
        }

        // Cập nhật permission_id cho các bản ghi có cùng user_id và permission_id
        $affectedRows = UserPermission::where('user_id', $userId)
                                       ->where('permission_id', $permissionId)
                                       ->update(['permission_id' => $newPermissionId]);

        if ($affectedRows > 0) {
            return response()->json(['message' => 'Cập nhật permission_id thành công'], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy userPermission để cập nhật'], 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $permissionId)
    {
        try {
            // Tìm và xóa user permission
            UserPermission::where('user_id', $userId)->where('permission_id', $permissionId)->delete();

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred while deleting user permission.'], 500);
        }
    }
}
