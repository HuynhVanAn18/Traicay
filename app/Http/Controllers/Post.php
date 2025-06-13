<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests\PostRequests;
use App\Http\Requests;
use Session;
use Illuminate\support\Facades\Redirect;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Posts;
use App\Models\Cateblog;
use App\Models\Brand;
use App\Models\Category;
use Auth;

class Post extends Controller
{
    /*kiểm tra nếu admin mới cho truy cập*/
   public function AuthenLogin(){
        $admin_id =Auth::id();
        if ($admin_id) {
            return redirect('dashboard');
        }else 
            return redirect('admin')->send();

    }

    public function add_post (){
        $this->AuthenLogin();
        $cate_post = Cateblog::orderBy('cate_blog_id','DESC')->get();
        return view('admin.Post.add_Post')->with(compact('cate_post'));
     }

    public function save_post (PostRequests $request){
        $this->AuthenLogin();
        $data = $request->all();
        $post = new Posts();
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_keywords = $data['post_keywords'];
        $post->post_status = $data['post_status'];
        $post->cate_blog_id = $data['cate_blog_id'];
        $get_image =$request->file('post_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName(); // lấy tên của hình ảnh
            $name_image = current(explode('.',$get_name_image)); //
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/post',$new_image);
            $post->post_image = $new_image;
            $post->save();
            Session::put('message','Thêm thành công');
            return redirect()->back();      
        }else{
            Session::put('message','Vui lòng thêm ảnh');
            return redirect()->back();
        }
        

    }
    public function all_post(){
        $this->AuthenLogin();
        $all_post = Posts::orderBy('post_id','DESC')->paginate(5);
        return view('admin.Post.all_post')->with(compact('all_post'));
    }
    public function delete_post($post_id){
        $this->AuthenLogin();
        $post = Posts::find($post_id);
        $post_image = $post->post_image;
        if ($post_image) {
            $path = 'upload/post/'.$post_image;//đường dẫn
            unlink($path);//xóa hình ảnh bài viết
        }
        $post->delete();
        Session::put('message','Xóa Thành Công');
        return redirect()->back();
    }
    public function edit_post($post_id){
        $this->AuthenLogin();
        $edit_post = Posts::where('post_id',$post_id)->get();
        $cate_post = Cateblog::orderBy('cate_blog_id','DESC')->get();
        return view('admin.Post.edit_post')->with(compact('edit_post','cate_post'));
    }


    public function update_post(Request $request,$post_id){
        $this->AuthenLogin();
        $data = $request->all();
        $post = Posts::find($post_id);
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_keywords = $data['post_keywords'];
        $post->post_status = $data['post_status'];
        $post->cate_blog_id = $data['cate_blog_id'];
        $get_image =$request->file('post_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName(); // lấy tên của hình ảnh
            $name_image = current(explode('.',$get_name_image)); //
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/post',$new_image);
            $post->post_image = $new_image;
            $post->save();
            Session::put('message','Cập nhập thành công');
            return redirect('all-post');      
        }else{
            Session::put('message','Vui lòng thêm ảnh');
            return redirect()->back();
        }
    }
//////////////////////////////////////////////////////////////////frontend//////////////////////////////////////////////////////////
    public function tin_tuc(Request $request){
        $category_blog = Cateblog::orderBy('cate_blog_id','DESC')->get();
        $category  = Category::where('category_status','1')->orderby('category_id','desc')->get();
        $brand = Brand::where('brand_status','1')->orderby('brand_id','desc')->get();
            $meta_desc = "Những Tin Tức Liên Quan Đến Trái Cây Sạch"; 
            $meta_keywords = "Tin Tức, Trái Cây Sạch, Ưu Đãi, Giảm Giá, ..."; 
            $meta_title = "Tin Tức Fresh Fruit"; ;
            $url_canonical = $request->url();
        $post = Posts::where('post_status',1)->orderBy('post_id','DESC')->paginate(6);
        return view('pages.blog.tin_tuc')->with(compact('category','brand','meta_desc','meta_keywords','meta_title','url_canonical','category_blog','post'));
    }
    public function danh_muc_bai_viet(Request $request,$post_slug){
       
        $category_blog = Cateblog::orderBy('cate_blog_id','DESC')->get();
        $category  = Category::where('category_status','1')->orderby('category_id','desc')->get();
        $brand = Brand::where('brand_status','1')->orderby('brand_id','desc')->get();
        $catepost = Cateblog::where('cate_blog_slug',$post_slug)->take(1)->get();
        foreach ($catepost as $key => $cate) {
            $meta_desc = $cate->cate_blog_desc; 
            $meta_keywords = $cate->cate_blog_slug;
            $meta_title = $cate->cate_blog_name;
            $cate_id = $cate->cate_blog_id; 
            $url_canonical = $request->url();
        }   
        $post = Posts::with('cate_post')->where('post_status',1)->where('cate_blog_id',$cate_id)->paginate(6);
        $post_new = Posts::where('post_status',1)->orderBy('post_id','DESC')->limit(3)->get();
        return view('pages.blog.blog')->with(compact('category','brand','meta_desc','meta_keywords','meta_title','url_canonical','category_blog','post','post_new'));
    }
    public function bai_viet(Request $request,$post_slug){
       
        $category_blog = Cateblog::orderBy('cate_blog_id','DESC')->get();
        $category  = Category::where('category_status','1')->orderby('category_id','desc')->get();
        $brand = Brand::where('brand_status','1')->orderby('brand_id','desc')->get();
        $post = Posts::with('cate_post')->where('post_status',1)->where('post_slug',$post_slug)->take(1)->get();
        foreach ($post as $key => $p) {
            $meta_desc = $p->post_meta_desc; 
            $meta_keywords = $p->post_keywords;
            $meta_title = $p->post_title;
            $cate_id = $p->cate_blog_id;
            $url_canonical = $request->url();
            $cate_blog_id = $p->cate_blog_id;
            $post_id = $p->post_id;

        }
        //update views
        $post_view = Posts::where('post_id',$post_id)->first();
        $post_view->post_views = $post_view->post_views + 1;
        $post_view->save();
        //san pham lien quan   
        $post_related = Posts::with('cate_post')->where('post_status',1)->where('cate_blog_id',$cate_blog_id)->whereNotIn('post_slug',[$post_slug])->take(3)->get();
        $post_new = Posts::where('post_status',1)->orderBy('post_id','DESC')->limit(3)->get();
        return view('pages.blog.bai_viet')->with(compact('category','brand','meta_desc','meta_keywords','meta_title','url_canonical','category_blog','post','post_related','post_new'));
    }
}
