<?php

namespace App\Http\Controllers;
use App\Http\Requests\PaymentRequests;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
use Cart;
use Mail;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Feeship;

class PaymentController extends Controller
{
    public function payment_online(Request $request){
    	$thanhtoan = $request ->all();
    	Session::put('thanhtoan',$thanhtoan);
    }
    public function thanh_toan(){
    	$data = Session::get('thanhtoan');
    	$checkout_code = substr(md5(microtime()),rand(0,26),5);
    	Session::put('code',$checkout_code);
    	return view('vnpay_php.index')->with(compact('data','checkout_code')) ;
	} 
    public function payment_continue (PaymentRequests $request){
    		$vnp_TxnRef = $request->order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
			$vnp_OrderInfo = $request->order_desc;
			$vnp_OrderType = $request->order_type;
			$vnp_Amount = $request->amount * 100;
			$vnp_Locale = config('app.locale');
			$vnp_BankCode = $request->bank_code;
			$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

			$inputData = array(
			    "vnp_Version" => "2.0.0",
			    "vnp_TmnCode" => env('VNP_TMN_CODE'),
			    "vnp_Amount" => $vnp_Amount,
			    "vnp_Command" => "pay",
			    "vnp_CreateDate" => date('YmdHis'),
			    "vnp_CurrCode" => "VND",
			    "vnp_IpAddr" => $vnp_IpAddr,
			    "vnp_Locale" => $vnp_Locale,
			    "vnp_OrderInfo" => $vnp_OrderInfo,
			    "vnp_OrderType" => $vnp_OrderType,
			    "vnp_ReturnUrl" => route('vnpayreturn'),
			    "vnp_TxnRef" => $vnp_TxnRef,
			);
			if (isset($vnp_BankCode) && $vnp_BankCode != "") {
			    $inputData['vnp_BankCode'] = $vnp_BankCode;
			}
			ksort($inputData);
			$query = "";
			$i = 0;
			$hashdata = "";
			foreach ($inputData as $key => $value) {
			    if ($i == 1) {
			        $hashdata .= '&' . $key . "=" . $value;
			    } else {
			        $hashdata .= $key . "=" . $value;
			        $i = 1;
			    }
			    $query .= urlencode($key) . "=" . urlencode($value) . '&';
			}

			$vnp_Url = env('VNP_URL') . "?" . $query;
			if (env('VNP_HASH_SECRET')) {
				$vnpSecureHash = hash('sha256', env('VNP_HASH_SECRET') . $hashdata);
				$vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
			}
			return redirect($vnp_Url);
	}
	public function return_payment(Request $request){
			if ($request->vnp_ResponseCode == '00') {
				$data = Session::get('thanhtoan');
				if (Session::get('coupon') != Null) {
		            $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
		            $coupon->coupon_qty = $coupon->coupon_qty -1;
		            $coupon_mail = $coupon->coupon_name;
		            $coupon_number = $coupon->coupon_number;
		            $coupon->save();
		         }
		         else{
		            $coupon_mail = 'Không có';
		            $coupon_number = 0;
		         }
		        //lưu shipping
				$shipping =  new Shipping();
				$shipping->shipping_name = $data['shipping_name'];
		        $shipping->shipping_city = $data['shipping_city'];
		        $shipping->shipping_address = $data['shipping_address'];
		        $shipping->shipping_phone = $data['shipping_phone'];
		        $shipping->shipping_email = $data['shipping_email'];
		        $shipping->shipping_note = $data['shipping_note'];
		        $shipping->shipping_method = $data['shipping_method'];
       			$shipping ->save();

				//save order
		        $shipping_id = $shipping->shipping_id; //sau khi save thì lấy id mới nhất 
		        $order = new Order;
		        $order->customer_id = Session::get('customer_id');
		        $order->shipping_id = $shipping_id;
		        $order->order_status = 1;
		        $order->order_code = Session::get('code');
		        date_default_timezone_set('Asia/Ho_Chi_Minh');
		        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
		        $order->created_at = now();
		        $order->order_date = $order_date;
		        $order->save();

		        
		        if(Session::get('cart')==true && Session::get('thanhtoan')) {
		        	$pay = Session::get('thanhtoan');
		            foreach (Session::get('cart') as $key => $cart) {
		                $order_details = new OrderDetails;
		                $order_details->order_code = Session::get('code');
		                $order_details->product_coupon = $pay['order_coupon'];
		                $order_details->product_feeship = $pay['order_fee'];
		                $order_details->product_id = $cart['product_id'];
		                $order_details->product_name = $cart['product_name'];
		                $order_details->product_price = $cart['product_price'];
		                $order_details->product_sales_quantity = $cart['product_qty'];
		                $order_details->save();
		            }
		        }
		        //send email
		        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
		        $title_mail = 'Đơn xác nhận mua hàng tại Fresh Fruit'. ' ' .$now;
		        $customer = Customer::find(Session::get('customer_id'));

		        $data['email'][] = $customer->customer_email;
		        //lấy giỏ hàng
		        if (Session::get('cart')==true) {
		            foreach (Session::get('cart') as $key => $cart_mail) {
		                $cart_array[] = array(
		                    'product_name' => $cart_mail['product_name'],
		                    'product_price' => $cart_mail['product_price'],
		                    'product_qty' => $cart_mail['product_qty']
		                );
		            }
		        }
		        //lấy phí ship
		        if(Session::get('fee')==true){
		            $fee = Session::get('fee');
		        }
		        else {
		            $fee = '25000';
		        }
		        //lấy shipping
		        $Shipping_array = array(
		            'customer_name' => $customer->customer_name,
		            'fee' => $fee,
		            'shipping_name' => $data['shipping_name'],
		            'shipping_city' => $data['shipping_city'],
		            'shipping_address' => $data['shipping_address'],
		            'shipping_phone' => $data['shipping_phone'],
		            'shipping_email' => $data['shipping_email'],
		            'shipping_note' => $data['shipping_note'],
		            'shipping_method' => $data['shipping_method']
		        );
		        $ordercode_mail =  array(
		            'coupon_code' => $coupon_mail,
		            'coupon_number' => $coupon_number,
		            'order_code' => Session::get('code')

		        );

		        Mail::send('pages.email.send_mail',['cart_array'=>$cart_array,'Shipping_array'=>$Shipping_array,'ordercode_mail'=>$ordercode_mail],
		            function($message) use ($title_mail, $data){
		            $message->to($data['email'])->subject($title_mail);
		            $message->from($data['email'],$title_mail);
		            });

		        Session::forget('coupon');
		        Session::forget('fee');
		        Session::forget('cart');
		        Session::forget('shipping_session');

		        //seo 
		        $meta_desc = "Giỏ hàng của bạn"; 
		        $meta_keywords = "Giỏ hàng Ajax";
		        $meta_title = "Giỏ hàng Ajax";
		        $url_canonical = $request->url();

				return view('pages.cart.cart_ajax')->with('message','Thanh Toán Thành Công')->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
			}
			else{
				 //seo 
		        $meta_desc = "Giỏ hàng của bạn"; 
		        $meta_keywords = "Giỏ hàng Ajax";
		        $meta_title = "Giỏ hàng Ajax";
		        $url_canonical = $request->url();

				return view('pages.cart.cart_ajax')->with('message','Thanh Toán Thất bại')->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
			}
			
	}
}
