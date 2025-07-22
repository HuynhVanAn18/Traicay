<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        // Use bcrypt for password hashing
        $new->admin_password = bcrypt($data['admin_password']);
        $new->admin_phone = $data['admin_phone'];
        $new->save();
        return redirect('/register-auth')->with('message','Đăng kí tài khoảng thành công');
    }
    public function login(Request $request){
        $this->validate($request,[
            'admin_name' => 'required|max:255',
            'admin_password' => 'required|max:255',
        ]);
        // Log input and stored password hash for debugging
        $user = Login::where('admin_name', $request->admin_name)->first();
        $roles = $user ? $user->roles()->pluck('name')->toArray() : [];
        Log::info('Login debug', [
            'admin_name' => $request->admin_name,
            'input_password' => $request->admin_password,
            'stored_password' => $user ? $user->admin_password : null,
            'roles' => $roles
        ]);
        if(Auth::attempt(['admin_name' => $request->admin_name, 'password' => $request->admin_password])) {
            $user = Auth::user();
            if ($user && $user->hasRole('staff')) {
                return redirect('/all-product');
            }
            return redirect('/dashboard');
        } else {
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
