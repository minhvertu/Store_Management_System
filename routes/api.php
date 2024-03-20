<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StorageController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Authentication
Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('refresh', [AuthController::class,'refresh']);
Route::post('logout', [AuthController::class,'logout']);

//Tasks
Route::resource('tasks', TaskController::class);

//View Users
Route::get('/users', [UserController::class, 'viewPermission']);

//Profile
Route::get('/profile/{user}', [UserController::class, 'show']);
Route::resource('editProfile', UserController::class);

//Employees
Route::resource('employees', EmployeeController::class);
Route::get('employees_export',[EmployeeController::class, 'get_employee_data'])->name('employee.export');

//Products
Route::resource('products', ProductController::class);
Route::get('products_export',[ProductController::class, 'get_product_data'])->name('product.export');

//Clients
Route::resource('clients', ClientController::class);

//Brands
Route::resource('brands', BrandController::class);

//Shops
Route::resource('shops', ShopController::class);

//Suppliers
Route::resource('suppliers', SupplierController::class);

//Storages
Route::resource('storages', StorageController::class);
