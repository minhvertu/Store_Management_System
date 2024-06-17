<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;

use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $users = User::with(['shop', 'role', 'permissions'])
                      ->whereNotIn('role_id', [4, 5]) // Lọc ra các người dùng có role_id không phải là 4 và 5
                      ->get();

         return response()->json($users);
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
            'User updated!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        //
        if ($request->user()->can('delete-employees')) {
            $user = User::find($id);
            $user->delete();
            return response([
                'status' => true,
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to delete Employee!'
        ], 200);
    }

    public function viewPermission(Request $request)
    {
        if ($request->user()->can('view-users')) {
            $user = User::with ([ 'role','shop', 'permissions'
            ])->get();
            return response()->json($user);
        }

        return response([
            'status' => false,
            'message' => 'You don\'t have permission to view users!'
        ], 200);
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = time() . '_' . $image->getClientOriginalName();
            $path = $request->file('image')->storeAs('profiles', $file_name, 'public');

            // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
            auth()->user()->update(['image' => $path]);

            return response()->json(['image' => $path]);
        }

        return response()->json(['error' => 'Failed to upload image.']);
    }

//     public function getTotalCustomers()
// {
//     $totalCustomer = User::where('role_id', 3)->count();

//     return response()->json(['totalCustomer' => $totalCustomer]);
// }
public function getTotalCustomers()
{
    $totalCustomer = Client::count();

    return response()->json(['totalCustomer' => $totalCustomer]);
}


public function countEmployee(Request $request)
{
    // if ($request->user()->hasRole('manager') || $request->user()->hasRole('admin')) {
        // Lấy role_id của người dùng đang đăng nhập
    $roleId = $request->user()->role_id;

    // Biến để lưu danh sách người dùng
    $users = collect();

    if ($roleId == 2) {
        // Nếu người dùng có role_id là 2 (quản lý hoặc chủ cửa hàng)
        // Truy vấn tất cả người dùng thuộc cửa hàng đó, ngoại trừ quản lý
        $shopId = $request->user()->shop_id;
        $users = User::where('shop_id', $shopId)
                     ->where('role_id', '!=', 2)
                     ->with ([ 'role','shop', 'permissions'
            ])
                     ->get();
    } elseif ($roleId == 5) {
        // Nếu người dùng có role_id là 4
        // Truy vấn toàn bộ người dùng (bao gồm cả nhân viên và quản lý) mà không cần xét đến shop_id
        $users = User::whereNotIn('role_id', [4,5])
        ->with(['role', 'shop', 'permissions'])
        ->get();
            return response()->json($users);
    }
    elseif ($roleId == 4) {
        // Nếu người dùng có role_id là 4
        // Truy vấn toàn bộ người dùng (bao gồm cả nhân viên và quản lý) mà không cần xét đến shop_id
        $users = User::whereNotIn('role_id', [4,5])
        ->with(['role', 'shop', 'permissions'])
        ->get();
            return response()->json($users);
    }
     else {
        // Nếu người dùng không có quyền quản lý hoặc quyền của role_id không phải là 2 hoặc 4
        return response()->json(['error' => 'You do not have permission to view this data'], 403);
    }

    // Trả về danh sách người dùng dưới dạng JSON
    return response()->json($users);
}
// }

public function get_user_data()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }

}
