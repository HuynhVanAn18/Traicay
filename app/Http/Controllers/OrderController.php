<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\Products;
use App\Models\Statistic;
use App\Models\Coupon;
use PDF;
use Session;
use Carbon\Carbon;
use Auth;
class OrderController extends Controller
{   public function AuthenLogin(){
        $admin_id =Auth::id();
        if ($admin_id) {
            return redirect('dashboard');
        }else 
            return redirect('admin')->send();

    }
    public function update_qty (Request $request){
      $this->AuthenLogin();
      $data = $request ->all();
      $order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
      $order_details->product_sales_quantity=$data['order_qty'];
      $order_details->save();
    }
    public function order_update_qty(Request $request){
      $this->AuthenLogin();
      //update order đã xử lí
      $data = $request ->all();
      $order = Order::find($data['order_id']);
      $order->order_status = $data['order_status'];
      $order->save();
      //order date (dùng cho statistic )
      $order_date = $order->order_date;
      $statistic = Statistic::where('order_date',$order_date)->get();
      if ($statistic) {
        $statistic_count = $statistic->count();
      }else{
        $statistic_count = 0;
      }
      //
      if ($order->order_status==2) {
        //(dùng cho statistic )
        $total_order = 0;
        $sales = 0;
        $quantity = 0;
        //
        foreach ($data['order_product_id'] as $key => $product_id) {
          $product = Products::find($product_id);
          $product_qty = $product->product_qty;
          $product_sold = $product->product_sold;
          //(dùng cho statistic )
          $product_price = $product->product_price;
          $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
          //
          foreach ($data['qty'] as $key2 => $qty) {
            if ($key == $key2) {
              $pro_remain = $product_qty -$qty;
              $product->product_qty = $pro_remain;
              $product->product_sold = $product_sold+$qty;
              $product->save();
              //update doanh thu (dùng cho statistic )
                  $total_order+=1;
                  $sales+=$product_price*$qty;
                  $quantity+=$qty;
              //
            }
          }
        }
        //update doanh số
        if ($statistic_count>0) {
          $statistic_update = Statistic::where('order_date',$order_date)->first();
          $statistic_update->sales = $statistic_update->sales + $sales;
          $statistic_update->quantity = $statistic_update->quantity + $quantity;
          $statistic_update->total_order = $statistic_update->total_order + $total_order;
          $statistic_update->save();
        }
        else{
          $statistic_new = new Statistic();
          $statistic_new->order_date = $order_date;
          $statistic_new->sales = $sales;
          $statistic_new->quantity = $quantity;
          $statistic_new->total_order = $total_order;
          $statistic_new->save();
        }
      }

    }
    public function print_order($checkout_code){
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($this->print_order_convert($checkout_code));
      return $pdf->stream();
    }
    public function print_order_convert($checkout_code){

     $order_details = OrderDetails::where('order_code',$checkout_code)->get();
     $order = Order::where('order_code',$checkout_code)->get();
     foreach ($order as $key => $ord) {
       $customer_id = $ord->customer_id;
       $shipping_id = $ord->shipping_id;
     }
     $customer = Customer::where('customer_id',$customer_id)->first();
     $shipping = Shipping::where('shipping_id',$shipping_id)->first();
     $order_details_product = OrderDetails::with('product')->where('order_code',$checkout_code)->get();
     foreach($order_details_product as $key => $order_d){

      $product_coupon = $order_d->product_coupon;
    }
      if($product_coupon != 'no'){
        $coupon = Coupon::where('coupon_code',$product_coupon)->first();

        $coupon_condition = $coupon->coupon_condition;
        $coupon_number = $coupon->coupon_number;

        if($coupon_condition==0){
          $coupon_echo = $coupon_number.'%';
        }elseif($coupon_condition==1){
          $coupon_echo = number_format($coupon_number,0,',','.').' '.'VNĐ';
        }
      }else{
        $coupon_condition = 2;
        $coupon_number = 0;

        $coupon_echo = '0';

      }
      $output = '';
      $output.='<style>body{
                  font-family: DejaVu Sans;
                }
                .Table {
                  background:#ffffff;
                  font: 15px;
                  width:100%;
                  border-collapse:collapse;
                  font-size:13px;
                  border:1px solid #d3d3d3;
                  text-align: center;
                }
                .Table_now {
                  background:#ffffff;
                  font: 15px;
                  width:100%;
                  border-collapse:collapse;
                  font-size:15px;
                  border:0px solid #d3d3d3;
                  text-align: center;
                  vertical-align:middle;
                }

                .Table th {
                  background: rgba(0,0,255,0.1);
                  text-align: center;
                  font-weight: bold;
                  background-color: gray;
                  border:1px solid #d3d3d3;

                }
                .Table tr {
                  height: 24px;
                  border:thin solid #d3d3d3;
                }
                .Table tr td {
                  padding-right: 2px;
                  padding-left: 2px;
                  border:thin solid #d3d3d3;
                }
                .Table tr:hover {
                  background: rgba(0,0,0,0.05);
                }
                .Table .cotSTT {
                  text-align:center;
                  width: 10%;
                }
                .Table .cotTenSanPham {
                  text-align:left;
                  width: 40%;
                }
                .Table .cotHangSanXuat {
                  text-align:left;
                  width: 20%;
                }
                .Table .cotGia {
                  text-align:right;
                  width: 120px;
                }
                .Table .cotSoLuong {
                  text-align: center;
                  width: 50px;
                }
                .Table .cotSo {
                  text-align: right;
                  width: 120px;
                }
                .Table .tong {
                  text-align: right;
                  font-weight:bold;
                  text-transform:uppercase;
                  padding-right: 4px;
                }
                .Table .cotSo {
                  text-align: center;
                }
                .img{
                  margin-top:1px;
                }
                </style>
                <table class="Table">
                  <h1><center>Trái Cây Fresh Fruit</center></h1>
                  <center><img src="https://i0.wp.com/s1.uphinh.org/2021/05/12/logo.jpg" height="150px" width="300px" class="img"></center>
                </table>
                <p>Tài khoản đặt hàng</p>
                <table class="Table">
                    <thead>
                      <tr>
                        <th>Tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>';
                    
                $output.='    
                      <tr>
                        <td>'.$customer->customer_name.'</td>
                        <td>'.$customer->customer_phone.'</td>
                        <td>'.$customer->customer_email.'</td>
                      </tr>';
                $output.='        
                    </tbody>
                </table>

                <p>Thông tin nhận hàng</p>
                  <table class="Table">
                    <thead>
                      <tr>
                        <th>Tên người nhận</th>
                        <th>Địa chỉ</th>
                        <th>Sdt</th>
                        <th>Email</th>
                        <th>Ghi chú</th>
                      </tr>
                    </thead>
                    <tbody>';
                    
                $output.='    
                      <tr>
                        <td>'.$shipping->shipping_name.'</td>
                        <td>'.$shipping->shipping_address.'</td>
                        <td>'.$shipping->shipping_phone.'</td>
                        <td>'.$shipping->shipping_email.'</td>
                        <td>'.$shipping->shipping_notes.'</td>
                        
                      </tr>';
                    

                $output.='        
                    </tbody>
                  
                </table>

                <p>Đơn hàng đặt</p>
                  <table class="Table">
                    <thead>
                      <tr>
                        <th>Tên sản phẩm</th>
                        <th>Mã giảm giá</th>
                        <th>Phí ship</th>
                        <th>Số lượng</th>
                        <th>Giá sản phẩm</th>
                        <th>Thành tiền</th>
                      </tr>
                    </thead>
                    <tbody>';
                  
                    $total = 0;

                    foreach($order_details_product as $key => $product){

                      $subtotal = $product->product_price*$product->product_sales_quantity;
                      $total+=$subtotal;

                      if($product->product_coupon!='no'){
                        $product_coupon = $product->product_coupon;
                      }else{
                        $product_coupon = 'không có';
                      }   

                $output.='    
                      <tr>
                        <td>'.$product->product_name.'</td>
                        <td>'.$product_coupon.'</td>
                        <td>'.number_format($product->product_feeship,0,',','.').' '.'VNĐ'.'</td>
                        <td>'.$product->product_sales_quantity.'</td>
                        <td>'.number_format($product->product_price,0,',','.').' '.'VNĐ'.'</td>
                        <td>'.number_format($subtotal,0,',','.').' '.'VNĐ'.'</td>
                      </tr>';
                    }

                    if($coupon_condition==0){
                      $total_after_coupon = ($total*$coupon_number)/100;
                              $total_coupon = $total - $total_after_coupon;
                    }else{
                                $total_coupon = $total - $coupon_number;
                    }

                $output.= '
                <tr>
                    <td colspan="12" style="text-align:right;">
                      <p>Tổng giảm: '.$coupon_echo.'</p>
                      <p>Phí ship: '.number_format($product->product_feeship,0,',','.').' '.'VNĐ'.'</p>
                      <p>Thanh toán : '.number_format($total_coupon + $product->product_feeship,0,',','.').' '.'VNĐ'.'</p>
                    </td>
                </tr>';
                $output.='        
                    </tbody>
                  
                </table>
                  <table>
                    <thead>
                      <tr>
                        <th width="200px">Người in hóa đơn</th>
                        
                        <th width="800px">Người nhận</th>
                      </tr>
                    </thead>
                    <tbody>';
                        
                $output.='        
                    </tbody>
                  
                </table>';
      return $output;
    }

    public function manage_order(){
        $order = Order::orderby('created_at','DESC')->paginate(5);
       
        return view('admin.Order.manage_order')->with(compact('order'));
    }

    public function view_order($order_code){
         
       $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
       $order = Order::where('order_code',$order_code)->get();
       foreach ($order as $key => $ord) {
           $customer_id = $ord->customer_id;
           $shipping_id = $ord->shipping_id;
           $order_status = $ord->order_status;
       }
       $customer = Customer::where('customer_id',$customer_id)->first();
       $shipping = Shipping::where('shipping_id',$shipping_id)->first();





       $order_details_product = OrderDetails::with('product')->where('order_code',$order_code)->get();
       foreach ($order_details_product as $key => $order_d) {
         $product_coupon = $order_d->product_coupon;
       }
       if($product_coupon != 'no'){
        $coupon = Coupon::where('coupon_code',$product_coupon)->first();
        $coupon_condition = $coupon->coupon_condition;
        $coupon_number = $coupon->coupon_number;
        }else{
          $coupon_condition = 2;
          $coupon_number = 0;
        }
       return view('admin.Order.view_order')->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));
    }

    public function delete_order($order_id){
        $this->AuthenLogin();
        $order = Order::find($order_id);
        $order->delete();
        Session::put('message','Xóa Thành Công');
        return redirect()->back();
        // return Redirect::to('manage-order');
    }

}
