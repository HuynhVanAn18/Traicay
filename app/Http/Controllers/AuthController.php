<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register_auth(){
    	return view('admin.admin.register_auth');
    }
    public function login_auth(){
        return view('admin.admin.login_auth');
    }
    public function logout_auth(){
        Auth::logout();
        return redirect('/admin')->with('message','Đăng xuất Thành Công');
    }
    public function register(Request $request){
    	$this->validation($request);
    	$data = $request->all();
    	$new = new Login();
    	$new->admin_name = $data['admin_name'];
    	$new->admin_email = $data['admin_email'];
    	$new->admin_password = md5($data['admin_password']);
    	$new->admin_phone = $data['admin_phone'];
    	$new->save();
    	return redirect('/register-auth')->with('message','Đăng kí tài khoảng thành công');
    }
    public function login(Request $request){
        $this->validate($request,[
            'admin_name' => 'required|max:255',
            'admin_password' => 'required|max:255',]);
        // $data = $request->all();
        if(Auth::attempt(['admin_name' => $request->admin_name, 'password' => $request->admin_password]))  {
            return redirect('/dashboard');
        }else{
            return redirect('/admin')->with('message','Tên đăng nhập hoặc mật khẩu không đúng');
        }
    }
    public function validation($request){
    	return $this->validate($request,[
    		'admin_name' => 'required|max:255',
    		'admin_password' => 'required|max:255',
    		'admin_email' => 'required|email|max:255',
    		'admin_phone' => 'required|max:255',
    	]);
    }
}
