<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\Category;
use App\Models\Products;
use App\Models\Brand;
use App\Models\Cateblog;
use Illuminate\support\Facades\Redirect;
use App\Models\Visiter;
session_start();

class HomeController extends Controller
{
    public function index(Request $request){ 
      //seo 
        $meta_desc = "Chuyên bán trái cây dinh dưỡng cao, hoàn toàn tự nhiên không sử dụng các loại hóa chất"; 
        $meta_keywords = "Trái cây, Trái cây tươi, Trái cây nhập khẩu, Trái cây sạch";
        $meta_title = "Fresh Fruit";
        $url_canonical = $request->url();
        //--seo
        //category blog
        $category_blog = Cateblog::orderBy('cate_blog_id','DESC')->get();
        //
        // truy cập
        $user_ip_address = $request->ip();
        //nguoi hien tai dang online
        $visiter_current = Visiter::where('ip_address',$user_ip_address);
        $visiter_count = $visiter_current->count();

        if ($visiter_count<1) {
            $visiter = new Visiter();
            $visiter->ip_address = $user_ip_address;
            $visiter->date_visiter = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visiter->save();
        }

        //
        $category  = Category::where('category_status','1')->orderby('category_id','desc')->get();
        $brand = Brand::where('brand_status','1')->orderby('brand_id','desc')->get();
        $all_product  = Products::where('product_status','1')->orderby('product_id','desc')->paginate(9);
        $product_price = Products::where('product_status','1')->orderby('product_price','desc')->limit(6)->get();
        $product_sold = Products::where('product_status','1')->orderby('product_sold','desc')->limit(6)->get();
        
        return view('pages.home')->with(compact('category','brand','all_product','meta_desc','meta_keywords','meta_title','url_canonical','product_sold','product_price','category_blog'));
    }
   public function tim_kiem(Request $request){
        //seo 
        $meta_desc = "Tìm kiếm sản phẩm"; 
        $meta_keywords = "Search,tìm kiếm,tra cứu,keywords";
        $meta_title = "Fresh Fruit";
        $url_canonical = $request->url();
        //--seo
        $keywords = $request->keywords_submit;
        $category  = Category::where('category_status','1')->orderby('category_id','desc')->get();
        $brand = Brand::where('brand_status','1')->orderby('brand_id','desc')->get();
        $search_product  = Products::where('product_name','like','%'.$keywords.'%')->get();
        return view('pages.product.seach_product')->with(compact('category','brand','search_product','meta_desc','meta_keywords','meta_title','url_canonical'));
   }
}
