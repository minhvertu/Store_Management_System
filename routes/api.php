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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductSizeAmountController;
use App\Http\Controllers\SizeController;

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

//* Users */

//View Users
Route::get('/users', [UserController::class, 'viewPermission']);

Route::get('/users/total-customers', [UserController::class, 'getTotalCustomers']);


Route::post('/upload-image', [UserController::class, 'uploadImage']);

//Profile
Route::get('/profile/{user}', [UserController::class, 'show']);
Route::resource('editProfile', UserController::class);

//Upload Users Image

//Employees
Route::resource('employees', EmployeeController::class);
Route::get('employees_export',[EmployeeController::class, 'get_employee_data'])->name('employee.export');

//Products

Route::resource('products', ProductController::class);
Route::get('products_export',[ProductController::class, 'get_product_data'])->name('product.export');
Route::post('/upload-product-image', [ProductController::class, 'uploadProductImage']);




//Clients
Route::resource('clients', ClientController::class);

//Brands
Route::resource('brands', BrandController::class);

//Shops
Route::resource('shops', ShopController::class);

//Suppliers
Route::resource('suppliers', SupplierController::class);

//Storages


Route::get('/storages/total-import-cost', [StorageController::class, 'calculateTotalImportCost']);

Route::resource('storages', StorageController::class);





//Categories
Route::resource('categories', CategoryController::class);

//Orders
Route::get('/orders/total-order', [OrderController::class, 'getTotalOrder']);

Route::get('/orders/total-price', [OrderController::class, 'getTotalOrderPrice']);



Route::resource('orders', OrderController::class);

//Order Product
Route::resource('orderProduct', OrderProductController::class);


//Orders
Route::resource('carts', CartController::class);

Route::post('/cart/add{ product }', [CartController::class, ' addToCart']);

Route::resource('sizes', SizeController::class);

Route::resource('product_size_amounts', ProductSizeAmountController::class);




