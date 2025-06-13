<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\support\Facades\Redirect;
use Illuminate\support\Facades\Route;
use App\Models\Roles;
use App\Models\Login;
use Auth;

class UserController extends Controller
{
    public function all_user(){
    	$admin = Login::with('roles')->orderBy('admin_id','DESC')->paginate(5);
    	return view('admin.user.all_user')->with(compact('admin'));
    }
    public function assign_roles(Request $request){
        if (Auth::id( )== $request->admin_id) {
            return redirect()->back()->with('message','Không Thể Phân Quyền Tài Khoản Của Chính Mình !');
        }
    	$user = Login::where('admin_name',$request->admin_name)->first();
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
    public function delete_user_roles($admin_id){
        if (Auth::id() == $admin_id) {
            return redirect()->back()->with('message','Không Thể Xóa Tài Khoản Của Chính Mình !');
        }
            $admin = Login::find($admin_id);
            if($admin) {
                $admin->roles()->detach();
                $admin->delete();
            }
            return redirect()->back()->with('message','Xóa User Thành Công');
    }
}
