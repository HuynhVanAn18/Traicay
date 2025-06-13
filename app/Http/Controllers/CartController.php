<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCouponRequests;
use App\Http\Requests\ExcelRequests;
use App\Http\Requests\ShipRequests;
use App\Imports\ExcelImportsCoupon;
use App\Exports\ExcelExportsCoupon;
use Excel;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\support\Facades\Redirect;
use App\Models\Coupon;
use Cart;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use Auth;
session_start();
class CartController extends Controller
{
    public function AuthenLogin(){
        $admin_id =Auth::id();
        if ($admin_id) {
            return redirect('dashboard');
        }else 
            return redirect('admin')->send();

    }
    public function total_home(){
             $cart = count(Session::get('cart'));
             $output ='';
             if ($cart>0) {
                $subtotal = 0;
                $total = 0;
                foreach(Session::get('cart') as $key => $cart){
                    $subtotal = $cart['product_price']*$cart['product_qty'];
                    $total+=$subtotal;
                }
                $output.= '<span>'.number_format($total,0,',','.').' '.' VNĐ</span>';
             }else{ 
                $output.= '<span>'.number_format($total,0,',','.').' '.' VNĐ</span>';
             }
             echo $output;
        }
    public function show_cart(){
        $cart = count(Session::get('cart'));
        $output ='';
        if($cart>0){
            $output.= '<li><a href="'.url('/gio-hang').'"><i class="fa fa-shopping-bag"></i> <span>'.$cart.'</span></a></li>';
        }else{
            $output.= '<li><a href="'.url('/gio-hang').'"><i class="fa fa-shopping-bag"></i> <span>0</span></a></li>';
        }
        echo $output;
    }
	public function delete_cart($session_id){
		$cart = Session::get('cart');
        if ($cart==true) {
            foreach ($cart as $key => $val) {
                if ($val['session_id']==$session_id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Xóa Sản Phẩm Thành Công');
        }else{
            return redirect()->back()->with('message','Xóa Sản Phẩm Thất Bại');
            }
	   }
    public function delete_all_cart(){
        $cart = Session::get('cart');
        if ($cart==true) {
            Session::forget('cart');
            return redirect()->back()->with('message','Xóa giỏ hàng thành công');
        }
    }
	public function update_cart(Request $request){
		$data = $request->all();
        $cart = Session::get('cart');
        $message = '';
        if ($cart==true) {
            foreach ($data['cart_qty'] as $key => $qty) {
                $i = 0;
                foreach ($cart as $session => $val) {
                    $i++;
                    if ($val['session_id']==$key && $qty < $cart[$session]['product_quantity']) {
                        $cart[$session]['product_qty'] = $qty;
                        $message.='<p style="color:green;">'.$i.'/ Cập Nhập Số Lượng '.$cart[$session]['product_name'].' Thành Công</p>';
                    }
                    elseif ($val['session_id']==$key && $qty > $cart[$session]['product_quantity']) {
                        $message.='<p style="color:red;">'.$i.'/ Số Lượng '.$cart[$session]['product_name'].' Phải Nhỏ Hơn '.$cart[$session]['product_quantity'].'</p>';
                    }
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message',$message);
            }else{
                return redirect()->back()->with('message','Cập Nhập Số Lượng Thất Bại');
        }

	}
public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart',$cart);
        }
       
        Session::save();

    }  


    public function gio_hang(Request $request){
         //seo 
        $meta_desc = "Giỏ hàng của bạn"; 
        $meta_keywords = "Giỏ hàng Ajax";
        $meta_title = "Giỏ hàng Ajax";
        $url_canonical = $request->url();
        //--seo
       $cate_product  = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
       $brand_product = DB::table('tbl_brand_product')->where('brand_status','1')->orderby('brand_id','desc')->get();

        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
// Coupon
    public function unset_coupon(Request $request){
        $coupon = Session::get('coupon');
        if ($coupon==true) {
            Session::forget('coupon');
            return redirect()->back()->with('message','Xóa Mã Giảm Giá Thành Công');
        }
    }
    public function check_coupon(Request $request){
        $data = $request->all();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $month_now = Carbon::now('Asia/Ho_Chi_Minh')->month;
        $year_now = Carbon::now('Asia/Ho_Chi_Minh')->year;
        $coupon = Coupon::where('coupon_code',$data['coupon'])->where('coupon_status','1')->first();
        $date_end = date_create($coupon->coupon_date_end);
        
            if ($coupon && $coupon->coupon_qty>0) {
                if(date_format($date_end, "m") >= $month_now && date_format($date_end, "Y") >= $year_now && $coupon->coupon_date_end >= $today){
                    $count_coupon = $coupon->count();
                    if ($count_coupon>0) {
                        $coupon_session = Session::get('coupon');
                        if ($coupon_session==true) {
                            $is_avaiable = 0;
                            if ($is_avaiable==0) {
                                $cou[] = array(
                                    'coupon_code'=>$coupon->coupon_code,
                                    'coupon_condition'=>$coupon->coupon_condition,
                                    'coupon_number'=>$coupon->coupon_number,
                                );
                                Session::put('coupon',$cou);
                            }
                        }else{
                            $cou[] = array(
                                    'coupon_code'=>$coupon->coupon_code,
                                    'coupon_condition'=>$coupon->coupon_condition,
                                    'coupon_number'=>$coupon->coupon_number,
                                );
                                Session::put('coupon',$cou);
                        }
                        Session::save();
                        return redirect()->back()->with('message','Thêm Mã Giảm Giá Thành Công');
                        }
                    }else{
                        return redirect()->back()->with('error','Mã Giảm Giá Không Đúng Hoặc Hết Hạn');
                    }
            }else{
                return redirect()->back()->with('error','Mã Giảm Giá Không Đúng Hoặc Đã Hết Mã');
        }
            
    }
    //////////////////////////////////////////////////////////////////////////////////backend////////////////////////////////////////////////////////
    public function add_coupon(){
        $this->AuthenLogin();
        return view('admin.Coupon.add_coupon');
    }
    public function save_coupon(AddCouponRequests $request){
        $this->AuthenLogin();
        $data = $request->all();
        $coupon = new Coupon;
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_qty = $data['coupon_qty'];
        $coupon->coupon_date_start = $data['coupon_date_start'];
        $coupon->coupon_date_end = $data['coupon_date_end'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->save();
         Session::put('message','Thêm Mã Giảm Giá Thành Công');
        return Redirect::to('all-coupon');                            

    }

    public function all_coupon(){
        $this->AuthenLogin();
        $all_coupon = Coupon::orderBy('coupon_id','DESC')->paginate(5);
        $month= Carbon::now('Asia/Ho_Chi_Minh')->month;
        $year = Carbon::now('Asia/Ho_Chi_Minh')->year;
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        return view('admin.Coupon.all_coupon')->with(compact('all_coupon','today','month','year'));
    }

    public function edit_coupon($coupon_id){
        $this->AuthenLogin();
        $edit_coupon = DB::table('tbl_coupon')->where('coupon_id',$coupon_id)->get();
        $manager_coupon = view('admin.Coupon.edit_coupon')->with('edit_coupon',$edit_coupon);
        return view('admin_layout')->with('admin.Coupon.edit_coupon',$manager_coupon);
    }
    public function update_coupon(AddCouponRequests $request,$coupon_id){
        $this->AuthenLogin();
        $data = array();
        $data ['coupon_name'] = $request->coupon_name;
        $data ['coupon_number'] = $request->coupon_number;
        $data ['coupon_code'] = $request->coupon_code;
        $data ['coupon_date_start'] = $request->coupon_date_start;
        $data ['coupon_date_end'] = $request->coupon_date_end;
        $data ['coupon_qty'] = $request->coupon_qty;
        $data ['coupon_condition'] = $request->coupon_condition;
        $data ['coupon_status'] = $request->coupon_status;
        DB::table('tbl_coupon')->where('coupon_id',$coupon_id)->update($data);
        Session::put('message','Cập nhập mã giảm giá thành công');
        return Redirect::to('all-coupon');
    }
    public function delete_coupon($coupon_id){
        $this->AuthenLogin();
        DB::table('tbl_coupon')->where('coupon_id',$coupon_id)->delete();
        Session::put('message','Xoá mã giảm giá thành công');
        return Redirect::to('all-coupon');
    }
    public function import_coupon(ExcelRequests $request){
        $this->AuthenLogin();
        $file = $request->file('file')->getRealPath();
        $import = new ExcelImportsCoupon;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }
        return back();
    }
    public function export_coupon(){
        $this->AuthenLogin();
        return Excel::download(new ExcelExportsCoupon , 'Coupon.xlsx');
    }


    //manage ship
    public function add_ship(){
        $this->AuthenLogin();
        $city = City::orderby('matp','ASC')->get();
        return view('admin.Ship.add_ship')->with(compact('city'));
    }

    public function select_city(Request $request){
       $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                    $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }


            }else{
                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>---Chọn xã phường---</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
            echo $output;
        }
    }
    public function save_ship(Request $request){
        $this->AuthenLogin();
        $data = $request ->all();
        $fee_ship = new Feeship();
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['wards'];
        $fee_ship->fee_ship = $data['fee_ship'];
        $fee_ship->save();
    }
    public function manage_ship(){
        $feeship = Feeship::orderby('fee_id','DESC')->get();
        $output = '';
        $output .= '<div class="card-body">
                    <div class="table-responsive">
                      <table class="table">
                        <thead class=" text-primary">
                          <th>
                            Tên Thành Phố
                          </th>
                          <th>
                            Tên Quận Huyện
                          </th>
                          <th>
                            Tên Xã Phường
                          </th>
                          <th>
                            Phí Ship
                          </th>
                        </thead>
                ';

                foreach($feeship as $key => $fee){

                $output.='
                <tbody>
                          <tr>
                            <td>
                              '.$fee->city->name_city.' 
                            </td>
                            <td>
                              '.$fee->province->name_quanhuyen.' 
                            </td>
                            <td>
                              '.$fee->wards->name_xaphuong.'
                            </td>
                            <td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_ship_edit">'.number_format($fee->fee_ship,0,',','.').'</td>
                          </tr>
                    </tbody
                    ';
                }
                $output.='      
                </table>
                </div>
                </div>
                ';

                echo $output;

        
    }

    public function update_ship(Request $request){
        $this->AuthenLogin();
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $fee_ship->fee_ship = $fee_value;
        $fee_ship->save();
    }
}