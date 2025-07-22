<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Models\Roles;
use App\Models\Login;
use Auth;
use Session;

class UserController extends Controller
{
    public function AuthenLogin(){
        $admin_id = Auth::id();
        if (!$admin_id) {
            return redirect('admin')->send();
        }
    }

    public function all_user(){
        $this->AuthenLogin();
        $query = Login::with('roles')->orderBy('admin_id','DESC');

        if (request('filter_name')) {
            $query->where('admin_name', 'like', '%' . request('filter_name') . '%');
        }
        if (request('filter_email')) {
            $query->where('admin_email', 'like', '%' . request('filter_email') . '%');
        }
        if (request('filter_role')) {
            $role = request('filter_role');
            $query->whereHas('roles', function($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $admin = $query->paginate(5)->appends(request()->except('page'));
        return view('admin.user.all_user')->with(compact('admin'));
    }
    
    public function assign_roles(Request $request){
        $this->AuthenLogin();
        
        if (Auth::id() == $request->admin_id) {
            return redirect()->back()->with('message','Không Thể Phân Quyền Tài Khoản Của Chính Mình !');
        }
        
        $user = Login::where('admin_name',$request->admin_name)->first();
        if (!$user) {
            return redirect()->back()->with('message','User không tồn tại!');
        }
        
        $user->roles()->detach();
        
        if ($request->author_role){
            $user->roles()->attach(Roles::where('name','author')->first());
        }
        if ($request->user_role) {
            $user->roles()->attach(Roles::where('name','user')->first());
        }
        if ($request->admin_role) {
            $user->roles()->attach(Roles::where('name','admin')->first());
        }
        
        return redirect()->back()->with('message','Trao quyền thành công');
    }
    
    public function add_user(){
        $this->AuthenLogin();
        return view('admin.user.add_user');
    }
    
    public function save_user(Request $request){
        $this->AuthenLogin();
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:tbl_admin,admin_email',
            'admin_password' => 'required|min:6',
            'admin_phone' => 'nullable|string|max:20'
        ]);
        $user = new Login();
        $user->admin_name = $request->admin_name;
        $user->admin_email = $request->admin_email;
        $user->admin_password = \Hash::make($request->admin_password);
        $user->admin_phone = $request->admin_phone;
        $user->save();
        // Chỉ phân quyền admin, user, staff
        if ($request->admin_role) {
            $user->roles()->attach(Roles::where('name','admin')->first());
        }
        if ($request->user_role) {
            $user->roles()->attach(Roles::where('name','user')->first());
        }
        if ($request->staff_role) {
            $user->roles()->attach(Roles::where('name','staff')->first());
        }
        return redirect()->back()->with('message','Thêm User Thành Công!');
    }
    
    public function delete_user_roles($admin_id){
        $this->AuthenLogin();
        
        if (Auth::id() == $admin_id) {
            return redirect()->back()->with('message','Không Thể Xóa Tài Khoản Của Chính Mình !');
        }
        
        $admin = Login::find($admin_id);
        if($admin) {
            $admin->roles()->detach();
            $admin->delete();
            return redirect()->back()->with('message','Xóa User Thành Công');
        }
        
        return redirect()->back()->with('message','User không tồn tại!');
    }
}
