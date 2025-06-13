<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Brand; 
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Posts;
use App\Models\Products;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\Ads;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         Paginator::useBootstrap();
         view()->composer('*',function($view){
            $product_donut = Products::all()->count();
            $post_donut = Posts::all()->count();
            $order_donut = Order::all()->count();
            $customer_donut = Customer::all()->count();
            $category_donut = Category::all()->count();
            $brand_donut = Brand::all()->count();
            $slider_home = Slider::where('slider_status','1')->orderBy('slider_id','DESC')->get();
            $contact_info = Contact::all();
            $ads_home = Ads::where('ads_status','1')->orderBy('ads_id','DESC')->take(2)->get();
            //count order new
            $order_new_dashboard = Order::where('order_status',1)->orderBy('order_id','DESC')->get();
            $count_order_dashboard = Count($order_new_dashboard);
            //bai viet huu ich
            $post_huuich = Posts::where('cate_blog_id',9)->get();
            $view->with(compact('product_donut','post_donut','order_donut','customer_donut','category_donut','brand_donut','slider_home','contact_info','ads_home','order_new_dashboard','count_order_dashboard','post_huuich'));
         });
        
    }
}
