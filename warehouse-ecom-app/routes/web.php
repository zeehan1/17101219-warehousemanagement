<?php

use App\Http\Controllers\BackendController\DashboardController\AdminDashboardController;
use App\Http\Controllers\BackendController\DashboardController\ModeratorController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\StoreController;
use App\Http\Controllers\SystemController\AppPayloadController;
use App\Http\Middleware\CheckAdminAccess;
use App\Http\Middleware\CheckModeratorAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckStatus;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([CheckStatus::class])->group(function () {
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'DashboardRoute'])->name('dashboard');
        Route::get('/', [DashboardController::class, 'DashboardRoute'])->name('/');
    });
    /**Backend */
    //Admin
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function(){
        Route::middleware([CheckAdminAccess::class])->group(function () {
            Route::prefix('/admin')->group(function () {
                Route::get('/moderator/user/panel', [AdminDashboardController::class, 'ViewModeratorPanelWithRegistration'])->name('moderator.panel');
                Route::post('/moderator/store', [AdminDashboardController::class, 'StoreModerator'])->name('store.moderator');
                Route::get('/moderator/status/update/{email}/{current_status}', [AdminDashboardController::class, 'ModeratorStatusUpdate'])->name('moderator.ststusUpdate');
                Route::get('/view/edit/moderator/details/{email}', [AdminDashboardController::class, 'ViewmoderatorEditPage'])->name('moderator.editPage');
                Route::post('/update/moderator', [AdminDashboardController::class, 'Updatederator'])->name('moderator.update');
                Route::get('/moderator/delete/{email}', [AdminDashboardController::class, 'GetDeleteModerator'])->name('moderator.delete');
                Route::get('/warehouse/area/panel', [AdminDashboardController::class, 'ViewWarehouseAreaPanel'])->name('warehouse.panel');
                Route::post('/warehouse/panel/store', [AdminDashboardController::class, 'StoreWareHouse'])->name('store.wareHouse');
                Route::post('/warehouse/area/panel/store', [AdminDashboardController::class, 'StoreWareHouseArea'])->name('store.area');
                Route::get('/catergory/product/panel', [AdminDashboardController::class, 'CategoryStockPanel'])->name('category.stockPanel');
                Route::get('/warehouse/status/update/{warehouse_id}/{current_status}', [AdminDashboardController::class, 'WarehouseStatusUpdate'])->name('warehouse.ststusUpdate');
                Route::get('/warehouse/delete/{warehouse_id}', [AdminDashboardController::class, 'GetWarehouseDelete'])->name('warehouse.delete');
                Route::post('/catergory/product/panel/store', [AdminDashboardController::class, 'StoreCategory'])->name('store.categoryAdmin');
                Route::get('/category/status/update/{name}/{current_status}', [AdminDashboardController::class, 'CategoryStatusUpdate'])->name('category.ststusUpdate');
                Route::post('/panel/store', [AdminDashboardController::class, 'StoreProduct'])->name('store.productAdmin');
                Route::get('/product/status/update/{sku}/{current_status}', [AdminDashboardController::class, 'ProductStatusUpdate'])->name('product.ststusUpdate');
                Route::get('/product/edit/page/{sku}', [AdminDashboardController::class, 'ProductEditView'])->name('product.edit');
                Route::post('/product/update', [AdminDashboardController::class,'ProductUpdate'])->name('product.update');
                Route::get('/stock/order/update/complete/{order_id}/{current_status}', [AdminDashboardController::class, 'StockOrderUpdateComplete'])->name('product.stockUpdateComplete');
                Route::get('/pre/order/update/complete/{order_id}/{current_status}', [AdminDashboardController::class, 'PreOrderUpdateComplete'])->name('product.preOrderUpdateComplete');
            });
        });
        //Moderator
        Route::middleware([CheckModeratorAccess::class])->group(function () {
            Route::prefix('/moderator')->group(function () {
                Route::get('/catergory/product/panel', [ModeratorController::class, 'CategoryProductPanelView'])->name('category.productPanel');
                Route::post('/catergory/product/panel/store', [ModeratorController::class, 'StoreCategory'])->name('store.category');
                Route::post('/product/panel/store', [ModeratorController::class, 'StoreProduct'])->name('store.product');
                Route::post('/register/stock/order', [ModeratorController::class, 'RegisterStockOrder'])->name('register.order');
                Route::post('/register/pre/order', [ModeratorController::class, 'RegisterPreOrder'])->name('register.preOrder');
            });
        });
    });
});


Route::prefix('/frontend')->group(function(){
    //register page
    Route::get('/user/resgister',[PageController::class, 'UserRegistration'])->name('register');
    Route::post('/store/user/resgister', [StoreController::class, 'StoreUserRegistration'])->name('store.register');
});

//Log out
Route::get('/log/out',[DashboardController::class,'Logout'])->name('logout');

