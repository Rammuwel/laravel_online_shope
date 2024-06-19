<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\DashcoardController as AminDashcoardController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategory;
use App\Http\Controllers\admin\productImageController;
use App\Http\Controllers\admin\ShippingChargeController;
use App\Http\Controllers\admin\DiscountCouponController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\SettingController;


use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;


// Route::get('/test', function () {
//     orderEmail(18);
// });

Route::get('/',[FrontController::class, 'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subCategorySlug?}',[ShopController::class, 'index'])->name('front.shop');

Route::get('/produc/{slug}',[ShopController::class, 'product'])->name('front.product');
Route::get('/cart',[CartController::class, 'cart'])->name('front.cart');
Route::post('/add-to-cart',[CartController::class, 'addToCart'])->name('front.addToCart');
Route::post('/update-to-cart',[CartController::class, 'cartUpdate'])->name('front.cartUpdate');
Route::post('/delete-to-cart',[CartController::class, 'deleteItem'])->name('front.deleteItem');
Route::get('/checkout',[CartController::class, 'checkout'])->name('front.checkout');
Route::post('/process-checkout',[CartController::class, 'processChackout'])->name('front.processChackout');
Route::get('/thankyou/{orderId}',[CartController::class, 'thankyou'])->name('front.thankyou');
Route::post('/get-order-summery',[CartController::class, 'getOrderSummery'])->name('front.getOrderSummery');
Route::post('/apply-discount',[CartController::class, 'applyDiscount'])->name('front.applyDiscount');
Route::post('/remove-discount',[CartController::class, 'removeDiscount'])->name('front.removeDiscount');
Route::post('/add-to-wishlist',[FrontController::class, 'addToWishList'])->name('front.addToWishList');
Route::get('/pages/{slug}',[FrontController::class, 'page'])->name('pages.page');
//ratting
Route::post('/ratting/review/{productId}', [ShopController::class, 'saveRattings'])->name('account.saveRattings');



Route::group(['prefix' => 'account'], function(){
    
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/register',[AuthController::class, 'register'])->name('account.register');
        Route::get('/login',[AuthController::class, 'login'])->name('account.login');
        Route::post('/login-authenticate',[AuthController::class, 'authenticate'])->name('account.authenticate');
        Route::post('/register-process', [AuthController::class, 'processRegister'])->name('account.processRegister');
        Route::get('/forget-password',[AuthController::class, 'forgetFassword'])->name('account.forgetFassword');
        Route::post('/process-forget-password',[AuthController::class, 'processForgetFassword'])->name('account.processForgetFassword');
        Route::get('/password/reset/{token}',[AuthController::class, 'resetPassword'])->name('front.resetPassword');
        Route::post('/password/reset/process',[AuthController::class, 'resetPasswordProcess'])->name('front.resetPasswordProcess');
    });
    
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/profile',[AuthController::class, 'profile'])->name('account.profile');
        Route::get('/logout',[AuthController::class, 'logout'])->name('account.logout');
        Route::get('/my-orders',[AuthController::class, 'orders'])->name('account.orders');
        Route::get('/order-details/{id}',[AuthController::class, 'orderDetails'])->name('account.orderDetails');
        Route::get('/wishlist',[AuthController::class, 'wishlist'])->name('account.wishlist');
        Route::delete('/wishlist/{id}',[AuthController::class, 'removeWishProduct'])->name('account.removeWishProduct');
        Route::post('/wishlist',[AuthController::class, 'removeWishProduct'])->name('account.update');
        Route::post('/update-profile',[AuthController::class, 'updateProfile'])->name('account.updateProfile');
        
        Route::get('/change-password', [AuthController::class, 'changePassword'])->name('account.changePassword');
        Route::post('/change-password', [AuthController::class, 'processChangePassword'])->name('account.processChangePassword');
        
        Route::post('/pages/contact', [FrontController::class, 'contactUs'])->name('account.contactUs');

        
    });
});

Route::group(['prefix' => 'admin'], function(){

    Route::group(['middleware' => 'admin.guest'], function(){

        Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminAuthController::class, 'authenticate'])->name('admin.authenticate');

    });

    Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('/dashboard', [AminDashcoardController::class, 'index'])->name('admin.dashboard'); 

        Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout'); 

        // categories
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        // Route::post('/upload-temp-img', [TempImagesController::class, 'create'])->name('temp-images.create');
        Route::post('/upload-temp-img', [TempImagesController::class, 'create'])->name('temp-images.create');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

        // sub_categories
        Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('sub-categories.index');
        Route::get('/sub_categories/create', [SubCategoryController::class, 'create'])->name('sub-categories.create');
        Route::post('/sub-categories/store', [SubCategoryController::class, 'store'])->name('sub-categories.store');

        Route::get('/sub-categories/{subCategory}/edit', [SubCategoryController::class, 'edit'])->name('sub-categories.edit');
        Route::put('/sub-categories/{subCategory}', [SubCategoryController::class, 'update'])->name('sub-categories.update');
        Route::delete('/sub-categories/{subCategory}', [SubCategoryController::class, 'destroy'])->name('sub-categories.delete');


        // brands
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');


        Route::get('/bramds/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/bramds/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/bramds/{brand}', [BrandController::class, 'destroy'])->name('brands.delete');
        
        // product route
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/product-subcategories', [ProductSubCategory::class, 'index'])->name('product-subcategories.index');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{productId}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{productId}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{productId}', [ProductController::class, 'destroy'])->name('products.delete');
        Route::get('/get-products', [ProductController::class, 'getProduct'])->name('products.getProduct');

        // product route
        Route::post('/product-image/upload', [productImageController::class, 'upload'])->name('product-image.upload');
        Route::delete('/product-image', [productImageController::class, 'destroy'])->name('product-image.destroy');

        // shipping routes
        Route::get('/shipping/create', [ShippingChargeController::class, 'create'])->name('shipping.create');
        Route::get('/shipping/{id}/edit', [ShippingChargeController::class, 'edit'])->name('shipping.edit');
        Route::post('/shipping/store', [ShippingChargeController::class, 'store'])->name('shipping.store');
        Route::delete('/shipping/{id}/delete', [ShippingChargeController::class, 'destroy'])->name('shipping.delete');
        Route::put('/shipping/{id}/update', [ShippingChargeController::class, 'update'])->name('shipping.update');


        // discount coupons routes
        Route::get('/coupons', [DiscountCouponController::class, 'index'])->name('coupons.index');
        Route::get('/coupons/create', [DiscountCouponController::class, 'create'])->name('coupons.create');
        Route::post('/coupons/store', [DiscountCouponController::class, 'store'])->name('coupons.store');
        Route::get('/coupons/{id}/edit', [DiscountCouponController::class, 'edit'])->name('coupons.edit');
        Route::put('/coupons/{id}/update', [DiscountCouponController::class, 'update'])->name('coupons.update');
        Route::delete('/coupons/{id}', [DiscountCouponController::class, 'destroy'])->name('coupons.destroy');

        // orders routes

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/order/details/{id}', [OrderController::class, 'details'])->name('orders.details');
        Route::post('/order/change-status/{orderId}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');
        Route::post('/order/send-email/{orderId}', [OrderController::class, 'senInvoiceEmail'])->name('orders.senInvoiceEmail');




        //users routes  users/create
           
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

        // pages route
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
        Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('pages.delete');
        Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
        
        
        
        // setting routes
        Route::get('/changePassword', [SettingController::class, 'changePassword'])->name('admin.changePassword');
        Route::post('/process-change-password', [SettingController::class, 'processChangePassword'])->name('admin.processChangePassword');


        



        Route::get('/getslug', function (Request $request) {
          
            $slug = '';
            $title = $request->input('title');
            if(!empty($title)){
              $slug = str::slug($title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getslug');
    });
});



