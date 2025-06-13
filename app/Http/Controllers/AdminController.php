<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;
use Session;
use Illuminate\support\Facades\Redirect;
session_start();
use App\Models\Social; //sử dụng model Social
use App\Models\Login; //sử dụng model Login
use App\Models\Statistic; 
use App\Models\Visiter;
use App\Models\Brand; 
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Posts;
use App\Models\Products;
use Auth;
use Socialite; //sử dụng Socialite
use Carbon\Carbon;




class AdminController extends Controller
{

    /*kiểm tra nếu admin mới cho truy cập*/
    public function AuthenLogin(){
        $admin_id =Auth::id();
        if ($admin_id) {
            return Redirect::to('dashboard');
        }else 
            return Redirect::to('admin')->send();

    }


     public function index(){
    	return view('admin.admin.admin_login');
    }
    public function show_dashboard(Request $request){
        $this->AuthenLogin();
        $user_ip_address = $request->ip();
        $trong_tuan_nay = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek(Carbon::MONDAY)->toDateString();
        $trong_thang_nay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        //trong tuan nay
        $visiter_tuan = Visiter::whereBetween('date_visiter',[$trong_tuan_nay,$now])->get();
        $visiter_tuan_count = $visiter_tuan->count();
        //trong thang nay
        $visiter_thang = Visiter::whereBetween('date_visiter',[$trong_thang_nay,$now])->get();
        $visiter_thang_count = $visiter_thang->count();
        //tat ca
        $visiter = Visiter::all();
        $visiter_total_count = $visiter->count();
        //nguoi hien tai dang online
        $visiter_current = Visiter::where('ip_address',$user_ip_address);
        $visiter_count = $visiter_current->count();

        if ($visiter_count<1) {
            $visiter = new Visiter();
            $visiter->ip_address = $user_ip_address;
            $visiter->date_visiter = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visiter->save();
        }
       
        //total morris donut
        $product_donut = Products::all()->count();
        $post_donut = Posts::all()->count();
        $order_donut = Order::all()->count();
        $customer_donut = Customer::all()->count();
        $category_donut = Category::all()->count();
        $brand_donut = Brand::all()->count();
        //lay view cao 
        $post_view = Posts::orderBy('post_views','DESC')->take(5)->get();
        $product_view = Products::orderBy('product_views','DESC')->take(10)->get();
        //bai viet moi nhat
        $post_new = Posts::orderBy('post_id','DESC')->take(3)->get();

    	return view('admin.dashboard')->with(compact('visiter_tuan_count','visiter_thang_count','visiter_count','visiter_total_count','product_donut','post_donut','order_donut','customer_donut','category_donut','brand_donut','post_view','product_view','post_new'));
    }
    public function dashboard(Request $request){
    	$admin_name = $request->admin_name;
    	$admin_password = md5($request->admin_password);
    	$result = DB::table('tbl_admin')->where('admin_name',$admin_name)->where('admin_password',$admin_password)->first();
    	if ($result) {
    		Session::put('admin_name',$result->admin_name);
    		Session::put('admin_id',$result->admin_id);
    		return Redirect::to('/dashboard');
    	}
    	else{

			Session::put('message','Tên đăng nhập hoặc mật khẩu không đúng');
			return Redirect::to('/admin');


    	}
    	return view('admin.dashboard');
    }
    public function logout(){
        $this->AuthenLogin();
    	Session::put('admin_name',null);
    	Session::put('admin_id',null);
    	return Redirect::to('/admin');
    }
    //fb
    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }else{

            $admin_login = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => ''

                ]);
            }
            $admin_login->login()->associate($orang);
            $admin_login->save();

            $account_name = Login::where('admin_name',$admin_login->user)->first();

            Session::put('admin_name',$admin_login->admin_name);
             Session::put('admin_id',$$admin_login->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } 
    }

    public function filter_by_date(Request $request){
        $data = $request ->all();
        $from_data = $data['from_data'];
        $to_date = $data['to_date'];
        $get = Statistic::whereBetween('order_date',[$from_data,$to_date])->orderBy('order_date','ASC')->get();
            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' => $val->total_order,
                    'sales' => $val->sales,
                    'quantity' => $val->quantity
                );
            }
            echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request){
        $data = $request->all();
        $dau_thangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();


        $sub7ngay = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365ngayqua = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        if ($data['dashboard_value']=='7ngayqua') {
            $get = Statistic::whereBetween('order_date',[$sub7ngay,$now])->orderBy('order_date','ASC')->get();
        }elseif ($data['dashboard_value']=='thangtruoc') {
            $get = Statistic::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();
        }elseif ($data['dashboard_value']=='thangnay') {
            $get = Statistic::whereBetween('order_date',[$dau_thangnay,$now])->orderBy('order_date','ASC')->get();
        }else{
            $get = Statistic::whereBetween('order_date',[$sub365ngayqua,$now])->orderBy('order_date','ASC')->get();
        }
        foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' => $val->total_order,
                    'sales' => $val->sales,
                    'quantity' => $val->quantity
                );
            }
            echo $data = json_encode($chart_data);
    }

    public function days_order(Request $request){
        $data = $request->all();
        $sub60days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(60)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistic::whereBetween('order_date',[$sub60days,$now])->orderBy('order_date','ASC')->get();
        foreach ($get as $key => $val) {
             $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' => $val->total_order,
                    'sales' => $val->sales,
                    'quantity' => $val->quantity
                );
            }
            echo $data = json_encode($chart_data);
    }

}
