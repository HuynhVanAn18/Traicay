<?php

namespace App\Http\Controllers;
use Mail;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Auth;
class MailController extends Controller
{
    public function AuthenLogin(){
        $admin_id =Auth::id();
        if ($admin_id) {
            return redirect('dashboard');
        }else 
            return redirect('admin')->send();

    }
    public function send_coupon($coupon_qty,$coupon_name,$coupon_condition,$coupon_number,$coupon_code){
        $this->AuthenLogin();
    	$customer = Customer::All();
        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;
    	$now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-y');
    	$title_mail = "Mã khuyến mãi siêu hấp dẫn, số lượng mã có hạn ".' '.$now;
    	$data = [];
    	foreach ($customer as $key => $c) {
    		$data['email'][] = $c->customer_email;
    	}
        $coupon = array(
            'start_coupon' => $start_coupon,
            'end_coupon' => $end_coupon,
            'coupon_qty' => $coupon_qty,
            'coupon_name' => $coupon_name,
            'coupon_condition' =>$coupon_condition,
            'coupon_number' =>$coupon_number,
            'coupon_code' =>$coupon_code
        );
    	Mail::send('admin.Email.send_coupon',['coupon'=>$coupon],function($message) use ($title_mail,$data,$coupon){
    		$message->to($data['email'])->subject($title_mail);//send this mail with subject
    		$message->from($data['email'],$title_mail);//send  from this mail
    	});
    	return redirect()->back()->with('message','Gửi mã khuyến mãi cho khách hàng thành công');
        // return view('admin.Email.send_coupon');
    }
}
