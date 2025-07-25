<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Cart;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Cateblog;
use App\Models\Category;
use App\Models\Products;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

use App\Controllers\CartController;

class CheckoutController extends Controller
{
    public function login_checkout()
    {

        return view('pages.checkout.login_checkout');
    }
    public function register_checkout()
    {

        return view('pages.checkout.register_checkout');
    }
    public function history_order(Request $request)
    {
        if (!Session::get('customer_id')) {
            return redirect('login-checkout')->with('message', 'Đăng nhập để xem lịch sử mua hàng');
        } else {
            //seo 
            $meta_desc = "Lịch Sử Đơn Hàng";
            $meta_keywords = "Lịch Sử Đơn Hàng";
            $meta_title = "Fresh Fruit";
            $url_canonical = $request->url();
            //--seo
            //category blog
            $category_blog = Cateblog::orderBy('cate_blog_id', 'DESC')->get();
            //
            $category  = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
            $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();
            $all_product  = Products::where('product_status', '1')->orderby('product_id', 'desc')->limit(10)->get();
            $product_price = Products::where('product_status', '1')->orderby('product_price', 'desc')->limit(6)->get();
            $product_sold = Products::where('product_status', '1')->orderby('product_sold', 'desc')->limit(6)->get();
            //lấy đơn hàng
            $getorder = Order::where('customer_id', Session::get('customer_id'))->orderby('order_id', 'DESC')->paginate(5);
            return view('pages.history.history_order')->with(compact('category', 'brand', 'all_product', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'product_sold', 'product_price', 'category_blog', 'getorder'));
        }
    }
    public function view_history_order(Request $request, $order_code)
    {
        if (!Session::get('customer_id')) {
            return redirect('login-checkout')->with('message', 'Đăng nhập để xem lịch sử mua hàng');
        } else {
            //seo 
            $meta_desc = "Lịch Sử Đơn Hàng";
            $meta_keywords = "Lịch Sử Đơn Hàng";
            $meta_title = "Fresh Fruit";
            $url_canonical = $request->url();
            //--seo
            //category blog
            $category_blog = Cateblog::orderBy('cate_blog_id', 'DESC')->get();
            //
            $category  = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
            $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();
            $all_product  = Products::where('product_status', '1')->orderby('product_id', 'desc')->limit(10)->get();
            $product_price = Products::where('product_status', '1')->orderby('product_price', 'desc')->limit(6)->get();
            $product_sold = Products::where('product_status', '1')->orderby('product_sold', 'desc')->limit(6)->get();
            //lấy chi tiết đơn hàng
            $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
            $order = Order::where('order_code', $order_code)->get();
            foreach ($order as $key => $ord) {
                $customer_id = $ord->customer_id;
                $shipping_id = $ord->shipping_id;
                $order_status = $ord->order_status;
            }
            $customer = Customer::where('customer_id', $customer_id)->first();
            $shipping = Shipping::where('shipping_id', $shipping_id)->first();

            $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();
            foreach ($order_details_product as $key => $order_d) {
                $product_coupon = $order_d->product_coupon;
            }
            if ($product_coupon != 'no') {
                $coupon = Coupon::where('coupon_code', $product_coupon)->first();
                $coupon_condition = $coupon->coupon_condition;
                $coupon_number = $coupon->coupon_number;
            } else {
                $coupon_condition = 2;
                $coupon_number = 0;
            }
            return view('pages.history.view_history_order')->with(compact('category', 'brand', 'all_product', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'product_sold', 'product_price', 'category_blog', 'order_details', 'customer', 'shipping', 'order_details', 'coupon_condition', 'coupon_number', 'order', 'order_status'));
        }
    }

    public function AuthenLogin()
    {
        $admin_id = Auth::id();
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else
            return Redirect::to('admin')->send();
    }

    // Hàm để lưu đơn hàng khi người dùng đã điền thông tin giao hàng và chọn phương thức vận chuyển
    public function save_order(Request $request)
    {
        dump($request->all());
        $data = $request->all();
        // Kiểm tra xem có sử dụng mã giảm giá hay không 
        if (Session::get('coupon') != Null) {
            $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
            $coupon->coupon_qty = $coupon->coupon_qty - 1; // Giảm số lượng mã giảm giá
            $coupon_mail = $coupon->coupon_name;
            $coupon_number = $coupon->coupon_number;
            $coupon->save();
        } else { // Nếu không có mã giảm giá thì gán giá trị mặc định
            $coupon_mail = 'Không có';
            $coupon_number = 0;
        }

        // Người dùng sẽ chọn phương thức vận chuyển và điền thông tin giao hàng
        // Lưu thông tin giao hàng vào bảng Shipping
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_city = $data['shipping_city'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_note = $data['shipping_note'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save(); // Câu lệnh này dùng để lưu thông tin giao hàng vào bảng Shipping


        // Tạo ra một mã code ngẫu nhiên gồm 5 chữ số để xác nhận đơn hàng
        $checkout_code = substr(md5(microtime()), rand(0, 26), 5);
        // Lưu vào bảng Order 
        $shipping_id = $shipping->shipping_id; 
        $order = new Order;
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->created_at = now();
        $order->order_date = $order_date;
        $order->save();

        // Lưu thông tin chi tiết đơn hàng vào bảng OrderDetails
        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart) {
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->save();
            }
        }


        // Gửi email xác nhận đơn hàng đến khách hàng
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = 'Đơn xác nhận mua hàng tại Fresh Fruit' . ' ' . $now;
        $customer = Customer::find(Session::get('customer_id'));
        $data['email'][] = $customer->customer_email;


        // Lấy giỏ hàng từ session
        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart_mail) {
                $cart_array[] = array(
                    'product_name' => $cart_mail['product_name'],
                    'product_price' => $cart_mail['product_price'],
                    'product_qty' => $cart_mail['product_qty']
                );
            }
        }


        // Lấy phí ship từ session, nếu không có thì gán giá trị mặc định
        if (Session::get('fee') == true) {
            $fee = Session::get('fee');
        } else {
            $fee = '25000';
        }


        // Tạo mảng để gửi thông tin giỏ hàng qua email
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

        // Tạo mảng để gửi thông tin đơn hàng qua email
        $ordercode_mail =  array(
            'coupon_code' => $coupon_mail,
            'coupon_number' => $coupon_number,
            'order_code' => $checkout_code

        );

        // Gửi email xác nhận đơn hàng 
        try {
            Mail::send(
                'pages.email.send_mail',
                ['cart_array' => $cart_array, 'Shipping_array' => $Shipping_array, 'ordercode_mail' => $ordercode_mail],
                function ($message) use ($title_mail, $data) {
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'], $title_mail);
                }
            );
        } catch (\Exception $e) {
            // Nếu gửi email thất bại, xóa dữ liệu đơn hàng khỏi session
            Session::forget('coupon');
            Session::forget('fee');
            Session::forget('cart');
            Log::error('Send mail failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gửi email thất bại. Đã xóa dữ liệu đơn hàng khỏi session.'], 500);
        }

        // Sau khi gửi email thành công, xóa dữ liệu đơn hàng khỏi session
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');

        // Điều hướng đến trang xác nhận đơn hàng sau khi lưu đơn hàng thành công
        return redirect()->route('order.confirmation')->with('cart', $cart); 
    }

    // public function save_order(Request $request)
    // {
    //     try {
    //         $data = $request->all();
    //         dd($data);
    //         // Check for required session data
    //         if (!Session::get('cart') || !Session::get('customer_id')) {
    //             Log::error('Missing cart or customer_id in session');
    //             return response()->json(['error' => 'Cart or customer not found'], 400);
    //         }

    //         // tru coupon
    //         if (Session::get('coupon') != null) {
    //             $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
    //             $coupon->coupon_qty = $coupon->coupon_qty - 1;
    //             $coupon_mail = $coupon->coupon_name;
    //             $coupon_number = $coupon->coupon_number;
    //             $coupon->save();
    //         } else {
    //             $coupon_mail = 'Không có';
    //             $coupon_number = 0;
    //         }

    //         // lưu shipping
    //         $shipping = new Shipping();
    //         $shipping->shipping_name = $data['shipping_name'];
    //         $shipping->shipping_city = $data['shipping_city'];
    //         $shipping->shipping_address = $data['shipping_address'];
    //         $shipping->shipping_phone = $data['shipping_phone'];
    //         $shipping->shipping_email = $data['shipping_email'];
    //         $shipping->shipping_note = $data['shipping_note'];
    //         $shipping->shipping_method = $data['shipping_method'];
    //         $shipping->save();

    //         // tự tạo mã code random 5 chữ số
    //         $checkout_code = substr(md5(microtime()), rand(0, 26), 5);
    //         // save order
    //         $shipping_id = $shipping->shipping_id; // sau khi save thì lấy id mới nhất 
    //         $order = new Order;
    //         $order->customer_id = Session::get('customer_id');
    //         $order->shipping_id = $shipping_id;
    //         $order->order_status = 1;
    //         $order->order_code = $checkout_code;
    //         date_default_timezone_set('Asia/Ho_Chi_Minh');
    //         $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
    //         $order->created_at = now();
    //         $order->order_date = $order_date;
    //         $order->save();

    //         if (Session::get('cart') == true) {
    //             foreach (Session::get('cart') as $key => $cart) {
    //                 $order_details = new OrderDetails;
    //                 $order_details->order_code = $checkout_code;
    //                 $order_details->product_coupon = $data['order_coupon'];
    //                 $order_details->product_feeship = $data['order_fee'];
    //                 $order_details->product_id = $cart['product_id'];
    //                 $order_details->product_name = $cart['product_name'];
    //                 $order_details->product_price = $cart['product_price'];
    //                 $order_details->product_sales_quantity = $cart['product_qty'];
    //                 $order_details->save();
    //             }
    //         }

    //         // send email
    //         $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
    //         $title_mail = 'Đơn xác nhận mua hàng tại Fresh Fruit' . ' ' . $now;
    //         $customer = Customer::find(Session::get('customer_id'));

    //         $data['email'][] = $customer->customer_email;
    //         // lấy giỏ hàng
    //         if (Session::get('cart') == true) {
    //             foreach (Session::get('cart') as $key => $cart_mail) {
    //                 $cart_array[] = array(
    //                     'product_name' => $cart_mail['product_name'],
    //                     'product_price' => $cart_mail['product_price'],
    //                     'product_qty' => $cart_mail['product_qty']
    //                 );
    //             }
    //         }
    //         // lấy phí ship
    //         if (Session::get('fee') == true) {
    //             $fee = Session::get('fee');
    //         } else {
    //             $fee = '25000';
    //         }
    //         // lấy shipping
    //         $Shipping_array = array(
    //             'customer_name' => $customer->customer_name,
    //             'fee' => $fee,
    //             'shipping_name' => $data['shipping_name'],
    //             'shipping_city' => $data['shipping_city'],
    //             'shipping_address' => $data['shipping_address'],
    //             'shipping_phone' => $data['shipping_phone'],
    //             'shipping_email' => $data['shipping_email'],
    //             'shipping_note' => $data['shipping_note'],
    //             'shipping_method' => $data['shipping_method']
    //         );
    //         $ordercode_mail =  array(
    //             'coupon_code' => $coupon_mail,
    //             'coupon_number' => $coupon_number,
    //             'order_code' => $checkout_code
    //         );

    //         Mail::send(
    //             'pages.email.send_mail',
    //             ['cart_array' => $cart_array, 'Shipping_array' => $Shipping_array, 'ordercode_mail' => $ordercode_mail],
    //             function ($message) use ($title_mail, $data) {
    //                 $message->to($data['email'])->subject($title_mail);
    //                 $message->from($data['email'], $title_mail);
    //             }
    //         );

    //         dd(Session::get('cart')); // Should show null or []
    //         // Now clear the session
    //         Session::forget('coupon');
    //         Session::forget('fee');
    //         Session::forget('cart');
    //     } catch (\Exception $e) {
    //         Log::error('Error saving order: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu đơn hàng. Vui lòng thử lại sau.');
    //     }
    // }
    public function del_fee()
    {
        Session::forget('fee');
        return redirect()->back();
    }

    public function calculate_ship(Request $request)
    {
        $data = $request->all();
        if ($data['matp']) {
            $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();
            if ($feeship) {
                $count_feeship = $feeship->count();
                if ($count_feeship > 0) {
                    foreach ($feeship as $key => $fee) {
                        Session::put('fee', $fee->fee_ship);
                        Session::save();
                    }
                } else {
                    Session::put('fee', 0);
                    Session::save();
                }
            }
        }
    }
    public function select_city_home(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                $output .= '<option>---Chọn quận huyện---</option>';
                foreach ($select_province as $key => $province) {
                    $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
                $output .= '<option>---Chọn xã phường---</option>';
                foreach ($select_wards as $key => $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
                }
            }
            echo $output;
        }
    }
    public function add_customer(Request $request)
    {

        // Đăng ký user vào bảng tbl_admin (Login model)
        $user = new \App\Models\Login();
        $user->admin_name = $request->input('customer_name');
        $user->admin_email = $request->input('customer_email');
        $user->admin_password = Hash::make($request->input('customer_password'));
        $user->admin_phone = $request->input('customer_phone');
        $user->save();
        // Gán quyền user mặc định
        $user->roles()->attach(\App\Models\Roles::where('name','user')->first());
        Session::put('customer_id', $user->id ?? $user->admin_id);
        Session::put('customer_name', $user->admin_name);
        return Redirect::to('/checkout');
    }
    public function checkout(Request $request)
    {
        if (Session::get('customer_id')) {
            //seo
            $meta_desc = "Thông tin thanh toán của bạn";
            $meta_keywords = "Thông tin thanh toán";
            $meta_title = "Thông tin thanh toán";
            $url_canonical = $request->url();
            //seo view check out dau
            $cate_product  = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();
            $city = City::orderby('matp', 'ASC')->get();
            return view('pages.checkout.checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('city', $city);
        } else {
            return redirect('/login-checkout')->with('message', 'Đăng Nhập Để Tiếp Tục !!');
        }
    }


    public function logout_checkout()
    {
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    public function reset_password()
    {
        return view('pages.checkout.reset_password');
    }
    public function send_reset(Request $request)
    {
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = 'Lấy lại mật khẩu tại Fresh Fruit' . ' ' . $now;
        $user = \App\Models\Login::where('admin_email', '=', $data['email_account'])->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email chưa đăng ký');
        }
        $token_random = Str::random();
        $user->admin_token = $token_random;
        $user->save();
        //send mail
        $to_email = $data['email_account'];
        $link_reset_pass = url('/update-password?email=' . $to_email . '&token=' . $token_random);
        $mail_data = array("name" => $title_mail, "body" => $link_reset_pass, 'email' => $data['email_account']);
        Mail::send('pages.email.reset_email', ['data' => $mail_data], function ($message) use ($title_mail, $mail_data) {
            $message->to($mail_data['email'])->subject($title_mail);
            $message->from($mail_data['email'], $title_mail);
        });
        return redirect()->back()->with('message', ' Vui lòng check email để reset password của bạn');
    }
    public function update_password(Request $request)
    {
        return view('pages.email.update_password');
    }
    public function update_password_new(Request $request)
    {
        $data = $request->all();
        $token_random = Str::random();
        $user = \App\Models\Login::where('admin_email', '=', $data['email'])
            ->where('admin_token', '=', $data['token'])->first();
        if ($user) {
            $user->admin_password = Hash::make($data['password_account']);
            $user->admin_token = $token_random;
            $user->save();
            return redirect('login-checkout')->with('message', 'Mật khẩu đã được cập nhật');
        } else {
            return redirect('reset-password')->with('error', 'Link của bạn đã hết hạn, vui lòng nhập lại email');
        }
    }
    public function login_customer(Request $request)
    {
        $name = $request->input('account_name');
        $password = $request->input('account_password');
        \Log::debug('Login attempt', ['name' => $name, 'password' => $password]);
        $user = \App\Models\Login::where('admin_name', $name)->first();
        \Log::debug('User found', ['user' => $user]);
        $passwordCheck = $user ? \Hash::check($password, $user->admin_password) : false;
        \Log::debug('Password check', ['result' => $passwordCheck]);
        if ($user && $passwordCheck) {
            Session::put('customer_id', $user->id ?? $user->admin_id);
            Session::put('customer_name', $user->admin_name);
            if (Session::get('cart')) {
                return Redirect::to('/checkout');
            } else {
                return Redirect::to('/trang-chu');
            }
        } else {
            return Redirect::to('/login-checkout')->with('message', 'Tài Khoản Hoặc Mật Khẩu Chưa Đúng !!');
        }
    }


    public function setShippingSession(Request $request)
{
    // Store all shipping info and fee in session
    Session::put('shipping_name', $request->shipping_name);
    Session::put('shipping_city', $request->shipping_city);
    Session::put('shipping_address', $request->shipping_address);
    Session::put('shipping_phone', $request->shipping_phone);
    Session::put('shipping_email', $request->shipping_email);
    Session::put('shipping_note', $request->shipping_note);
    Session::put('payment', $request->payment);
    Session::put('fee', $request->fee);

    return response()->json(['status' => 'success']);
}
public function setFee(Request $request)
    {
        Session::put('fee', $request->fee);
        return response()->json(['status' => 'success', 'fee' => $request->fee]);
    }
}
