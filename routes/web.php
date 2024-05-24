<?php

use App\Http\Controllers\AccessoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
|
*/

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\BasicInfoController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\HomeFeatureController;
use App\Http\Controllers\admin\DealController;
use App\Http\Controllers\admin\BlogCategoryController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AboutUsController;
use App\Http\Controllers\admin\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\SubChildController;
use App\Http\Controllers\AssignLocationItemController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController as ControllersCategoryController;
use App\Http\Controllers\frontend\CategoryFEController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProductAllocateController;
use App\Http\Controllers\ProductStatusController;
use App\Http\Controllers\ReceiveRequestController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransferRequestController;
use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});

Route::view('/', 'admin.auth.login');
Route::prefix('admin')->namespace('App\Http\Controllers\admin')->group(function () {

    // Route::match(['get', 'post'], 'login', [AdminController::class, 'login']);

    Route::post('login', [AdminController::class, 'login']);
    Route::middleware('admin')->group(function () {
        Route::post('logout', [AdminController::class, 'logout']);

        //    Brand route 
        Route::get('/brand/all', [BrandController::class, 'index'])->name('brand.index');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
        Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
        Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
        Route::post('/brand/update', [BrandController::class, 'update'])->name('brand.update');
        Route::delete('/brand/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete');

        //    Accessories route 
        Route::get('/accessories', [AccessoryController::class, 'index'])->name('accessories.index');
        Route::get('/accessories/create', [AccessoryController::class, 'create'])->name('accessories.create');
        Route::post('/accessories/store', [AccessoryController::class, 'store'])->name('accessories.store');
        Route::get('/accessories/edit/{id}', [AccessoryController::class, 'edit'])->name('accessories.edit');
        Route::post('/accessories/update', [AccessoryController::class, 'update'])->name('accessories.update');
        Route::get('/accessories/delete/{id}', [AccessoryController::class, 'destroy'])->name('accessories.delete');

        //    Category route 
        Route::get('/category/all', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');

        //    Suppliers route start here 
        Route::get('/supplier/all', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::post('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');

        //    Product route start here ---->
        Route::get('/product/all', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        //    Product route ends here ---->

        //    Product Allocate route start here ---->
        Route::get('/product-allocate/all', [ProductAllocateController::class, 'index'])->name('product-allocate.index');
        Route::get('/product-allocate/create', [ProductAllocateController::class, 'create'])->name('product-allocate.create');
        Route::post('/product-allocate/store', [ProductAllocateController::class, 'store'])->name('product-allocate.store');
        Route::get('/product-allocate/show/{id}', [ProductAllocateController::class, 'show'])->name('product-allocate.show');
        Route::get('/product-allocate/edit/{id}', [ProductAllocateController::class, 'edit'])->name('product-allocate.edit');
        Route::post('/product-allocate/update', [ProductAllocateController::class, 'update'])->name('product-allocate.update');
        Route::delete('/product-allocate/delete/{id}', [ProductAllocateController::class, 'destroy'])->name('product-allocate.destroy');


        //    Product Allocate route start here ---->
        Route::get('/product-status/all', [ProductStatusController::class, 'index'])->name('product-status.index');
        Route::post('/product-status/show', [ProductStatusController::class, 'show'])->name('product-status.show');
        Route::get('/product-status/create', [ProductStatusController::class, 'create'])->name('product-status.create');
        Route::post('/product-status/store', [ProductStatusController::class, 'store'])->name('product-status.store');
        // Route::post('/product-status/single-store/{id}', [ProductStatusController::class, 'singleStore'])->name('product-status.single-store');

        //    Trtansfer Request route start here ---->
        Route::get('/transfer-request/all', [TransferRequestController::class, 'index'])->name('transfer-request.index');
        Route::get('/transfer-request/create', [TransferRequestController::class, 'create'])->name('transfer-request.create');
        Route::post('/transfer-request/store', [TransferRequestController::class, 'store'])->name('transfer-request.store');
        Route::get('/transfer-request/show/{id}', [TransferRequestController::class, 'show'])->name('transfer-request.show');
        Route::get('/transfer-request/edit/{id}', [TransferRequestController::class, 'edit'])->name('transfer-request.edit');
        Route::post('/transfer-request/update', [TransferRequestController::class, 'update'])->name('transfer-request.update');
        Route::delete('/transfer-request/delete/{id}', [TransferRequestController::class, 'destroy'])->name('transfer-request.destroy');
        
        //    Trtansfer Request route start here ---->
        Route::get('/receive-request/all', [ReceiveRequestController::class, 'index'])->name('receive-request.index');
        // Route::get('/receive-request/create', [ReceiveRequestController::class, 'create'])->name('receive-request.create');
        // Route::post('/receive-request/store', [ReceiveRequestController::class, 'store'])->name('receive-request.store');
        // Route::get('/receive-request/show/{id}', [ReceiveRequestController::class, 'show'])->name('transfer-request.show');
        Route::get('/receive-request/edit/{id}', [ReceiveRequestController::class, 'edit'])->name('receive-request.edit');
        Route::post('/receive-request/update', [ReceiveRequestController::class, 'update'])->name('receive-request.update');
        Route::delete('/receive-request/delete/{id}', [ReceiveRequestController::class, 'destroy'])->name('receive-request.destroy');


        //    Trtansfer Request route ends here ---->

        Route::prefix('profile')->group(function () {
            Route::post('check-admin-password', [AdminController::class, 'checkAdminPassword']);
            Route::match(['get', 'post'], 'update-admin-details/{id?}', [AdminController::class, 'updateAdminDetails'])->name('admins.update.details');
            Route::match(['get', 'post'], 'update-admin-password/{id?}', [AdminController::class, 'updateAdminPassword'])->name('admins.update.password');
        });

        Route::resource('dashboard', DashboardController::class);
        Route::resource('basic-infos', BasicInfoController::class);
        Route::prefix('admin')->group(function () {
            Route::resource('roles', RoleController::class);
            Route::resource('admins', AdminController::class);
        });

        // Route::match(['get', 'post'], 'basic-infos-localization/{id}/{lang}', [BasicInfoController::class, 'localization']);

        // Route::resource('sliders', SliderController::class);

        Route::prefix('office')->group(function () {
            //    office location 
            Route::get('/all', [OfficeController::class, 'index'])->name('office.index');
            Route::get('/create', [OfficeController::class, 'create'])->name('office.create');
            Route::post('/store', [OfficeController::class, 'store'])->name('office.store');
            Route::get('/edit/{id}', [OfficeController::class, 'edit'])->name('office.edit');
            Route::post('/update', [OfficeController::class, 'update'])->name('office.update');
            // Route::get('/delete/{id}', [OfficeController::class, 'destroy'])->name('office.delete');

            // Route::resource('office', CategoryController::class);
            // Route::match(['get', 'post'], 'ofice-location/{id}/{lang}', [CategoryController::class, 'location']);

            // Route::resource('sub-categories', SubCategoryController::class);
            // Route::match(['get', 'post'], 'subcategory-localization/{id}/{lang}', [SubCategoryController::class, 'localization']);
            // Route::get('sub-cat-load/{subCatID}', [SubCategoryController::class, 'subCatLoad']);

            // Route::resource('sub-child', SubChildController::class);
            // Route::match(['get', 'post'], 'subchild-localization/{id}/{lang}', [SubChildController::class, 'localization']);

            // Route::resource('products', ProductController::class);
            // Route::match(['get', 'post'], 'product-localization/{id}/{lang}', [ProductController::class, 'localization']);

            // Route::get('load-sub-child/{id}', [ProductController::class, 'subChild']);
        });

        // Route::resource('/coupons_manage', CouponController::class);
        // Route::resource('reviews', ReviewController::class);

        // Route::resource('/messages', MessageController::class);
        // Route::get('/messages/status/{id}', [MessageController::class, 'updateStatus'])->name('messages.status');

        // Route::resource('/services', ServiceController::class);
        // Route::match(['get', 'post'], 'services-localization/{id}/{lang}', [ServiceController::class, 'localization']);

        // Route::resource('/orders', OrderController::class);
        // Route::get('/orders/invoice/{id}/{print?}', [OrderController::class, 'invoice'])->name('orders.print');

        // Route::resource('/home-features', HomeFeatureController::class);
        // Route::resource('deals', DealController::class);

        // Route::resource('/blog-category', BlogCategoryController::class);
        // Route::match(['get', 'post'], 'blog-category-localization/{id}/{lang}', [BlogCategoryController::class, 'localization']);

        // Route::resource('/blogs', BlogController::class);
        // Route::match(['get', 'post'], 'blog-localization/{id}/{lang}', [BlogController::class, 'localization']);

        // Route::resource('/customers', UserController::class);

        // Route::resource('/about-us', AboutUsController::class);
    });
});

require __DIR__ . '/auth.php';
