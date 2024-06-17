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
use App\Http\Controllers\DescriptionImageController;
use App\Http\Controllers\OrderOnlineController;
use App\Http\Controllers\ProductShopController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GenderController;

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
// Route::get('/users/delete-employees/{users}', [UserController::class, 'destroy']);


Route::get('users_export',[UserController::class, 'get_user_data'])->name('user.export');


Route::get('/users/total-employees', [UserController::class, 'countEmployee']);

Route::get('/users', [UserController::class, 'viewPermission']);

Route::get('/users/total-customers', [UserController::class, 'getTotalCustomers']);


Route::post('/upload-image', [UserController::class, 'uploadImage']);

//Profile
Route::get('/profile/{user}', [UserController::class, 'show']);
Route::resource('editProfile', UserController::class);
Route::resource('users', UserController::class);



//Upload Users Image

//Employees
Route::resource('employees', EmployeeController::class);
Route::get('employees_export',[EmployeeController::class, 'get_employee_data'])->name('employee.export');

//Products


Route::resource('products', ProductController::class);
Route::get('products_export',[ProductController::class, 'get_product_data'])->name('product.export');
Route::post('/upload-product-image', [ProductController::class, 'uploadProductImage']);
Route::post('/upload-description-image', [ProductController::class, 'uploadDescriptionImages']);



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

Route::get('/storages/monthly-import-cost', [StorageController::class, 'calculateMonthlyShopImportCost']);


Route::get('/storages/total-import_cost-shop', [StorageController::class, 'calculateShopImportCost']);

Route::resource('storages', StorageController::class);





//Categories
Route::resource('categories', CategoryController::class);

//Orders

Route::get('orders_export',[OrderController::class, 'get_order_data'])->name('order.export');


Route::get('/orders/total-revenue-shop', [OrderController::class, 'calculateShopRevenue']);

Route::get('/orders/monthly-revenue-shop', [OrderController::class, 'calculateMonthlyShopRevenue']);


Route::get('/orders/total-online-revenue-shop', [OrderController::class, 'calculateOnlineOrders']);




Route::get('/orders/total-order', [OrderController::class, 'getTotalOrder']);

Route::get('/orders/total-shop-order', [OrderController::class, 'getTotalShopOrder']);


Route::get('/orders/total-price', [OrderController::class, 'getTotalOrderPrice']);



Route::resource('orders', OrderController::class);

//Order Product
Route::resource('orderProduct', OrderProductController::class);


//Orders
Route::resource('carts', CartController::class);

Route::post('/cart/add{ product }', [CartController::class, ' addToCart']);

Route::resource('sizes', SizeController::class);


Route::get('/product_size_amounts_by_shop', [ProductSizeAmountController::class, 'getProductSizeAmountByShop']);

Route::resource('product_size_amounts', ProductSizeAmountController::class);


Route::resource('descriptionImages', DescriptionImageController::class);


Route::resource('orderOnline', OrderOnlineController::class);


Route::get('/client-profile/{client}', [ClientController::class, 'show']);

Route::resource('editClientProfile', ClientController::class);

Route::resource('productShop', ProductShopController::class);


Route::get('/get1products', [ProductShopController::class, 'getProductsByBrand']);
Route::get('/get-4-expensive-products', [ProductShopController::class, 'getTopFourExpensiveProducts']);
Route::get('/get-4-cheap-products', [ProductShopController::class, 'getTopFourCheapProducts']);

Route::get('/get-4-best-selling-products', [ProductShopController::class, 'getRandomFourGlassesProducts']);

Route::get('/get-4-top-rated-products', [ProductShopController::class, 'getRandomFourAccessoriesProducts']);

Route::get('/randomProducts', [ProductShopController::class, 'getRandomProducts']);


Route::post('/userPermissionsUpdate', [UserPermissionController::class, 'update']);


Route::resource('userPermissions', UserPermissionController::class);

Route::resource('permissions', PermissionController::class);


Route::post('/userRolesUpdate', [UserRoleController::class, 'update']);


// Route::put('/userRoles/{userId}/{roleId}', [UserRoleController::class, 'update']);


// Route::resource('userRoles', UserRoleController::class);
// Route::put('/userRoles/{userId}', [UserRoleController::class, 'update']);


Route::get('/userRoles', [UserRoleController::class, 'index']);




Route::resource('roles', RoleController::class);


Route::resource('genders', GenderController::class);


Route::get('/products/sizes', [ProductController::class, 'getProductSizes']);

Route::delete('/userPermissions/{userId}/{permissionId}', [UserPermissionController::class, 'destroy']);



