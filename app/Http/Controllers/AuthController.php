<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','refresh','logout']]);
    }

    public function register(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:6',
    ]);


    // Lấy email và kiểm tra định dạng
    $email = $request->email;
    $name = $request->name;
    $password = Hash::make($request->password);
    $token = null;
    $responseData = [];

    if (str_contains($email, '@Shop1employee.com')) {
        // Tạo user với role_id = 1
        $employeeCode = $this->generateEmployeeCode();
        $roleId = 1;
        $shopId = 2;
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'employee_code' => $employeeCode,
            'role_id' => $roleId,
            'shop_id' => $shopId,

        ]);

        // Đăng nhập người dùng và tạo token
        $token = Auth::guard('api')->login($user);
        $responseData = [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ];
    } else if (str_contains($email, '@Shop2employee.com')) {
        // Tạo user với role_id = 1
        $employeeCode = $this->generateEmployeeCode();
        $roleId = 1;
        $shopId = 3;
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'employee_code' => $employeeCode,
            'role_id' => $roleId,
            'shop_id' => $shopId,

        ]);

        // Đăng nhập người dùng và tạo token
        $token = Auth::guard('api')->login($user);
        $responseData = [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ];
    }
     elseif (str_contains($email, '@Shop1manager.com')) {
        // Tạo user với role_id = 2
        $roleId = 2;
        $shopId = 2;
        $employeeCode = $this->generateEmployeeCode();
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'employee_code' => $employeeCode,
            'role_id' => $roleId,
            'shop_id' => $shopId,
        ]);

        // Đăng nhập người dùng và tạo token
        $token = Auth::guard('api')->login($user);
        $responseData = [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ];
    } elseif (str_contains($email, '@Shop2manager.com')) {
        // Tạo user với role_id = 2
        $roleId = 2;
        $shopId = 3;
        $employeeCode = $this->generateEmployeeCode();
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'employee_code' => $employeeCode,
            'role_id' => $roleId,
            'shop_id' => $shopId,
        ]);

        // Đăng nhập người dùng và tạo token
        $token = Auth::guard('api')->login($user);
        $responseData = [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ];
    }
     else {
        // Tạo client
        $client = Client::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        // Đăng nhập client và tạo token
        $clientToken = Auth::guard('client')->login($client);
        $responseData = [
            'client' => $client,
            'authorisation' => [
                'token' => $clientToken,
                'type' => 'bearer',
            ],
        ];
    }

    // Trả về phản hồi JSON chứa thông tin người dùng, client, và token (nếu có)
    $responseData['status'] = 'success';
    $responseData['message'] = 'Account created successfully';
    return response()->json($responseData)
                     ->header('Authorization', $token);
}


public function login(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Lấy thông tin đăng nhập từ yêu cầu
    $credentials = $request->only('email', 'password');

    // Thử đăng nhập với guard 'api' cho bảng 'users'
    $token = Auth::guard('api')->attempt($credentials);
    if (!$token) {
        // Nếu đăng nhập bằng 'api' không thành công, thử đăng nhập với guard 'client' cho bảng 'clients'
        $token = Auth::guard('client')->attempt($credentials);

        if (!$token) {
            // Nếu không đăng nhập thành công với cả 'api' và 'client', trả về lỗi
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        // Lấy thông tin 'client' đang đăng nhập
        $client = Auth::guard('client')->user();

        // Trả về phản hồi JSON với thông tin 'client' và token
        return response()->json([
            'status' => 'success',
            'client' => $client,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ])->header('Authorization', $token);
    }

    // Lấy thông tin 'user' đang đăng nhập
    $user = Auth::guard('api')->user();
    $permissions = $user->permissions;
    $shopId = $user->shop_id;

    // Trả về phản hồi JSON với thông tin 'user' và token
    return response()->json([
        'status' => 'success',
        'user' => $user,
        'permission_id' => $permissions,
        'shop_id' => $shopId,
        'authorisation' => [
            'token' => $token,
            'type' => 'bearer',
        ]
    ])->header('Authorization', $token);
}
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }


    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => Auth::guard('api')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function generateEmployeeCode()
    {
        $digits = 3; // Số lượng chữ số
        $letters = 2; // Số lượng chữ cái

        $numbers = '';
        for ($i = 0; $i < $digits; $i++) {
            $numbers .= mt_rand(0, 9); // Tạo ngẫu nhiên chữ số từ 0 đến 9
        }

        $characters = '';
        $lettersRange = range('A', 'Z'); // Mảng chứa các chữ cái từ A đến Z
        for ($i = 0; $i < $letters; $i++) {
            $characters .= $lettersRange[array_rand($lettersRange)]; // Chọn ngẫu nhiên một chữ cái từ mảng
        }

        return 'EMP' . $numbers . $characters;
    }




}
