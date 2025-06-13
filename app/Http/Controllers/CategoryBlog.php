<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Imports\ExcelImportsCateBlog;
use App\Exports\ExcelExportsCateBlog;
use App\Http\Requests\CategoryPostRequests;
use App\Http\Requests\ExcelRequests;
use Excel;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\support\Facades\Redirect;
use App\Models\Cateblog;
use Auth;
session_start();

class CategoryBlog extends Controller
{
     /*kiểm tra nếu admin mới cho truy cập*/
   public function AuthenLogin(){
        $admin_id =Auth::id();
        if ($admin_id) {
            return redirect('dashboard');
        }else 
            return redirect('admin')->send();

    }

    public function add_category_blog (){
        $this->AuthenLogin();
        return view('admin.Blog.add_category_blog');
	 }
    public function all_category_blog (){
        $this->AuthenLogin();
        $all_category_blog = CateBlog::orderBy('cate_blog_id','DESC')->paginate(5); //phân trang, 5 danh mục trên trang
        return view('admin.Blog.all_category_blog')->with(compact('all_category_blog'));
    }
    public function save_category_blog (CategoryPostRequests $request){
        $this->AuthenLogin();
        $data = $request->all();
        $category_blog = new Cateblog();
        $category_blog->cate_blog_name = $data['cate_blog_name'];
        $category_blog->cate_blog_desc = $data['cate_blog_desc'];
        $category_blog->cate_blog_status = $data['cate_blog_status'];
        $category_blog->cate_blog_slug= $data['cate_blog_slug'];
        $category_blog->save();
        Session::put('message','Thêm thành công');
        return redirect()->back();
    }

    

    public function edit_category_blog($category_blog_id){
        $this->AuthenLogin();
        $edit_category_blog = Cateblog::find($category_blog_id);
        return view('admin.Blog.edit_category_blog')->with(compact('edit_category_blog'));
    }


    public function update_category_blog(CategoryPostRequests $request,$cate_blog_id){
        $this->AuthenLogin();
        $data = $request->all();
       	$category_blog = Cateblog::find($cate_blog_id);
        $category_blog->cate_blog_name = $data['cate_blog_name'];
        $category_blog->cate_blog_desc = $data['cate_blog_desc'];
        $category_blog->cate_blog_status = $data['cate_blog_status'];
        $category_blog->cate_blog_slug= $data['cate_blog_slug'];
        $category_blog->save();
        Session::put('message','Cập nhập thành công');
        return redirect()->back();


    }
    public function delete_category_blog($cate_blog_id){
        $this->AuthenLogin();
        $category_blog = Cateblog::find($cate_blog_id);
        $category_blog->delete();
        Session::put('message','Xóa thành công');
        return redirect('all-category-blog');
    }

    public function import_cateblog(ExcelRequests $request){
      $this->AuthenLogin();
      $file = $request->file('file')->getRealPath();
        $import = new ExcelImportsCateBlog;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }
        return back();
    }
    public function export_cateblog(){
        $this->AuthenLogin();
        return Excel::download(new ExcelExportsCateBlog , 'categoryBlog.xlsx');
    }

}
