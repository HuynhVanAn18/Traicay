<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/','App\Http\Controllers\HomeController@index');
Route::get('/trang-chu','App\Http\Controllers\HomeController@index');
Route::post('/tim-kiem','App\Http\Controllers\HomeController@tim_kiem');


//danh muc sản phẩm
Route::get('/danh-muc-san-pham/{category_slug}','App\Http\Controllers\CategoryProduct@show_category_home');
//danh mục thương hiệu
Route::get('/thuong-hieu-san-pham/{brand_slug}','App\Http\Controllers\BrandProduct@show_brand_home');
//chi tiết sản phẩm
Route::get('/chi-tiet-san-pham/{product_slug}','App\Http\Controllers\Product@chi_tiet');
//cart
Route::post('/update-cart','App\Http\Controllers\CartController@update_cart');
Route::get('/delete-cart/{session_id}','App\Http\Controllers\CartController@delete_cart');
Route::post('/add-cart-ajax','App\Http\Controllers\CartController@add_cart_ajax');
Route::get('/gio-hang','App\Http\Controllers\CartController@gio_hang');
Route::get('/delete-all-cart','App\Http\Controllers\CartController@delete_all_cart');
Route::get('/show-cart','App\Http\Controllers\CartController@show_cart');
Route::get('/total-home','App\Http\Controllers\CartController@total_home');

//checkpout
Route::get('/login-checkout','App\Http\Controllers\CheckoutController@login_checkout');
Route::get('/logout-checkout','App\Http\Controllers\CheckoutController@logout_checkout');
Route::get('/checkout','App\Http\Controllers\CheckoutController@checkout');
Route::post('/login-customer','App\Http\Controllers\CheckoutController@login_customer');
//reset password
Route::get('/register-checkout','App\Http\Controllers\CheckoutController@register_checkout');
Route::post('/add_customer','App\Http\Controllers\CheckoutController@add_customer')->name('add_customer');
Route::get('/reset-password','App\Http\Controllers\CheckoutController@reset_password');
Route::get('/update-password','App\Http\Controllers\CheckoutController@update_password');
Route::post('/send-reset','App\Http\Controllers\CheckoutController@send_reset');
Route::post('/update-password-new','App\Http\Controllers\CheckoutController@update_password_new');
//fee ship
Route::post('/select-city-home','App\Http\Controllers\CheckoutController@select_city_home');
Route::post('/calculate-ship','App\Http\Controllers\CheckoutController@calculate_ship');
Route::get('/del-fee','App\Http\Controllers\CheckoutController@del_fee');
//Save Order
Route::post('/save-order','App\Http\Controllers\CheckoutController@save_order');
//language
Route::get('/language/{language}','App\Http\Controllers\LanguageController@language');
//coupon
Route::post('/check-coupon','App\Http\Controllers\CartController@check_coupon');
Route::get('/unset-coupon/','App\Http\Controllers\CartController@unset_coupon');
// //send email
// Route::get('/send-email','App\Http\Controllers\CheckoutController@send_email');
//bài viết
Route::get('/tin-tuc','App\Http\Controllers\Post@tin_tuc');
Route::get('/danh-muc-bai-viet/{post_slug}','App\Http\Controllers\Post@danh_muc_bai_viet');
Route::get('/bai-viet/{post_slug}','App\Http\Controllers\Post@bai_viet');
//thanh toán payment
Route::post('/payment-online','App\Http\Controllers\PaymentController@payment_online');
Route::get('/thanh-toan','App\Http\Controllers\PaymentController@thanh_toan');
Route::post('/payment-continue','App\Http\Controllers\PaymentController@payment_continue');
Route::get('/vnpay-return',['as'=>'vnpayreturn','uses'=>'App\Http\Controllers\PaymentController@return_payment']);
//History order
Route::get('/history-order','App\Http\Controllers\CheckoutController@history_order');
Route::get('/view-history-order/{order_code}','App\Http\Controllers\CheckoutController@view_history_order');




// //////////////////////////////////////Backend//////////////////////////////////////////////////////



//Admin Dashboard
Route::get('/admin','App\Http\Controllers\AuthController@login_auth');
Route::get('/dashboard','App\Http\Controllers\AdminController@show_dashboard');
Route::get('/logout','App\Http\Controllers\AdminController@logout');
Route::post('/admin-dashboard','App\Http\Controllers\AdminController@dashboard');
Route::post('/filter-by-date','App\Http\Controllers\AdminController@filter_by_date');
Route::post('/dashboard-filter','App\Http\Controllers\AdminController@dashboard_filter');
Route::post('/days-order','App\Http\Controllers\AdminController@days_order');
//information
Route::get('/layout-footer','App\Http\Controllers\Information@layout_footer');
Route::get('/all-footer','App\Http\Controllers\Information@all_footer');
Route::get('/edit-footer/{info_id}','App\Http\Controllers\Information@edit_footer');
Route::get('/delete-footer/{info_id}','App\Http\Controllers\Information@delete_footer');
Route::post('/save-footer','App\Http\Controllers\Information@save_footer');
Route::post('/update-footer/{info_id}','App\Http\Controllers\Information@update_footer');

//Category Product
Route::get('/add-category-product','App\Http\Controllers\CategoryProduct@add_category_product');
Route::get('/all-category-product','App\Http\Controllers\CategoryProduct@all_category_product');
Route::get('/edit-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@delete_category_product');
Route::get('/unactive-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@active_category_product');
Route::post('/save-category-product','App\Http\Controllers\CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@update_category_product');
Route::post('/export-cate','App\Http\Controllers\CategoryProduct@export_cate');
Route::post('/import-cate','App\Http\Controllers\CategoryProduct@import_cate');

//Category Blog

Route::get('/add-category-blog','App\Http\Controllers\CategoryBlog@add_category_blog');
Route::get('/all-category-blog','App\Http\Controllers\CategoryBlog@all_category_blog');
Route::get('/edit-category-blog/{category_blog_id}','App\Http\Controllers\CategoryBlog@edit_category_blog');
Route::get('/delete-category-blog/{cate_blog_id}','App\Http\Controllers\CategoryBlog@delete_category_blog');
Route::post('/save-category-blog','App\Http\Controllers\CategoryBlog@save_category_blog');
Route::post('/update-category-blog/{cate_blog_id}','App\Http\Controllers\CategoryBlog@update_category_blog');
Route::post('/export-cateblog','App\Http\Controllers\CategoryBlog@export_cateblog');
Route::post('/import-cateblog','App\Http\Controllers\CategoryBlog@import_cateblog');

//Posts

Route::get('/add-post','App\Http\Controllers\Post@add_post');
Route::get('/all-post','App\Http\Controllers\Post@all_post');
Route::get('/delete-post/{post_id}','App\Http\Controllers\Post@delete_post');
Route::get('/edit-post/{post_id}','App\Http\Controllers\Post@edit_post');
Route::post('/update-post/{post_id}','App\Http\Controllers\Post@update_post');
Route::post('/save-post','App\Http\Controllers\Post@save_post');

//Brand Product

Route::get('/add-brand-product','App\Http\Controllers\BrandProduct@add_brand_product');
Route::get('/all-brand-product','App\Http\Controllers\BrandProduct@all_brand_product');
Route::get('/edit-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@delete_brand_product');
Route::get('/unactive-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@active_brand_product');
Route::post('/save-brand-product','App\Http\Controllers\BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@update_brand_product');
Route::post('/export-brand','App\Http\Controllers\BrandProduct@export_brand');
Route::post('/import-brand','App\Http\Controllers\BrandProduct@import_brand');

//Product

Route::get('/add-product','App\Http\Controllers\Product@add_product');
Route::get('/all-product','App\Http\Controllers\Product@all_product');
Route::get('/edit-product/{product_id}','App\Http\Controllers\Product@edit_product');
Route::get('/delete-product/{product_id}','App\Http\Controllers\Product@delete_product');
Route::get('/unactive-product/{product_id}','App\Http\Controllers\Product@unactive_product');
Route::get('/active-product/{product_id}','App\Http\Controllers\Product@active_product');
Route::post('/save-product','App\Http\Controllers\Product@save_product');
Route::post('/update-product/{product_id}','App\Http\Controllers\Product@update_product');

//coupon

Route::get('/add-coupon','App\Http\Controllers\CartController@add_coupon');
Route::get('/all-coupon','App\Http\Controllers\CartController@all_coupon');
Route::post('/save-coupon','App\Http\Controllers\CartController@save_coupon');
Route::post('/update-coupon/{coupon_id}','App\Http\Controllers\CartController@update_coupon');
Route::get('/delete-coupon/{coupon_id}','App\Http\Controllers\CartController@delete_coupon');
Route::get('/edit-coupon/{coupon_id}','App\Http\Controllers\CartController@edit_coupon');
Route::post('/export-coupon','App\Http\Controllers\CartController@export_coupon');
Route::post('/import-coupon','App\Http\Controllers\CartController@import_coupon');

//send mail

Route::get('/send-coupon/{coupon_qty}/{coupon_name}/{coupon_condition}/{coupon_number}/{coupon_code}','App\Http\Controllers\MailController@send_coupon');

//Ship

Route::get('/add-ship','App\Http\Controllers\CartController@add_ship');
Route::post('/update-ship','App\Http\Controllers\CartController@update_ship');
Route::post('/manage-ship','App\Http\Controllers\CartController@manage_ship');
Route::post('/select-city','App\Http\Controllers\CartController@select_city');
Route::post('/save-ship','App\Http\Controllers\CartController@save_ship');

//order

Route::get('/manage-order','App\Http\Controllers\OrderController@manage_order');
Route::get('/view-order/{order_code}','App\Http\Controllers\OrderController@view_order');
Route::post('/order-update-qty','App\Http\Controllers\OrderController@order_update_qty');
Route::post('/update-qty','App\Http\Controllers\OrderController@update_qty');
Route::get('/delete-order/{order_id}','App\Http\Controllers\OrderController@delete_order');

//print
Route::get('/print-order/{checkout_code}','App\Http\Controllers\OrderController@print_order');
//Authentication roles
Route::get('/register-auth','App\Http\Controllers\AuthController@register_auth');
// Route::get('/login-auth','App\Http\Controllers\AuthController@login_auth');
Route::get('/logout-auth','App\Http\Controllers\AuthController@logout_auth');
Route::post('/register','App\Http\Controllers\AuthController@register');
Route::post('/login','App\Http\Controllers\AuthController@login')->name('login_admin');
//user

Route::get('/all-user','App\Http\Controllers\UserController@all_user');
Route::get('/delete-user-roles/{admin_id}','App\Http\Controllers\UserController@delete_user_roles');
Route::post('/assign-roles','App\Http\Controllers\UserController@assign_roles');

//slider
Route::get('/add-slider','App\Http\Controllers\SliderController@add_slider');
Route::get('/edit-slider/{slider_id}','App\Http\Controllers\SliderController@edit_slider');
Route::post('/save-slider','App\Http\Controllers\SliderController@save_slider');
Route::post('/update-slider/{slider_id}','App\Http\Controllers\SliderController@update_slider');
Route::get('/all-slider','App\Http\Controllers\SliderController@all_slider');
Route::get('/delete-slider/{slider_id}','App\Http\Controllers\SliderController@delete_slider');
Route::get('/unactive-slider/{slider_id}','App\Http\Controllers\SliderController@unactive_slider');
Route::get('/active-slider/{slider_id}','App\Http\Controllers\SliderController@active_slider');

//ads
Route::get('/add-ads','App\Http\Controllers\SliderController@add_ads');
Route::get('/edit-ads/{ads_id}','App\Http\Controllers\SliderController@edit_ads');
Route::post('/save-ads','App\Http\Controllers\SliderController@save_ads');
Route::post('/update-ads/{ads_id}','App\Http\Controllers\SliderController@update_ads');
Route::get('/all-ads','App\Http\Controllers\SliderController@all_ads');
Route::get('/delete-ads/{ads_id}','App\Http\Controllers\SliderController@delete_ads');
Route::get('/unactive-ads/{ads_id}','App\Http\Controllers\SliderController@unactive_ads');
Route::get('/active-ads/{ads_id}','App\Http\Controllers\SliderController@active_ads');