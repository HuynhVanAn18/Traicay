<?php

namespace App\Http\Controllers;
use App\Http\Requests\SliderRequests;
use App\Http\Requests\AdsRequests;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Ads;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
class SliderController extends Controller
{
   public function AuthenLogin(){
        $admin_id =Auth::id();
        if ($admin_id) {
            return redirect('dashboard');
        }else 
            return redirect('admin')->send();

    }
    public function all_slider(){
        $this->AuthenLogin();
    	$all_slider = Slider::orderBy('slider_id','DESC')->paginate(5);
    	return view('admin.Slider.all_slider')->with(compact('all_slider'));
    }
    public function add_slider(){
        $this->AuthenLogin();
    	return view('admin.Slider.add_slider');
    }
    public function edit_slider($slider_id){
        $this->AuthenLogin();
        $slider = Slider::where('slider_id',$slider_id)->get();
        return view('admin.Slider.edit_slider')->with(compact('slider'));
    }
    public function unactive_slider($slider_id){
        $this->AuthenLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>1]);
        Session::put('message','kích hoạt thành công');
        return Redirect::to('all-slider');

    }
    public function active_slider($slider_id){
        $this->AuthenLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>0]);
        Session::put('message','Ẩn thành công');
        return Redirect::to('all-slider');

    }
    
    public function save_slider(SliderRequests $request){
    	$this->AuthenLogin();
   		$data = $request->all();
       	$get_image = request('slider_image');
      
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/slider', $new_image);

            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_status = $data['slider_status'];
            $slider->slider_desc = $data['slider_desc'];
           	$slider->save();
            Session::put('message','Thêm thành công');
            return Redirect::to('add-slider');
        }else{
        	Session::put('message','Vui lòng thêm hình ảnh');
    		return Redirect::to('add-slider');
        }
       	
    }
    public function update_slider(SliderRequests $request,$slider_id){
        $this->AuthenLogin();
        $data = $request->all();
        $get_image = request('slider_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/slider', $new_image);

            $slider = Slider::find($slider_id);
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_status = $data['slider_status'];
            $slider->slider_desc = $data['slider_desc'];
            $slider->save();
            Session::put('message','cập nhập thành công');
            return Redirect::to('all-slider');
        }else{
            Session::put('message','Vui lòng thêm hình ảnh');
            return Redirect::to('all-slider');
        }
        
    }
    public function delete_slider(Request $request, $slider_id){
        $this->AuthenLogin();
        $slider = Slider::find($slider_id);
        $slider_image = $slider->slider_image;
        if ($slider_image) {
            $path = 'upload/slider/'.$slider_image;//đường dẫn
            unlink($path);//xóa hình ảnh bài viết
        }
        $slider->delete();
        Session::put('message','Xóa thành công');
        return redirect()->back();

    }


    //ADS
    public function all_ads(){
        $this->AuthenLogin();
        $all_ads = Ads::orderBy('ads_id','DESC')->paginate(5);
        return view('admin.Ads.all_ads')->with(compact('all_ads'));
    }
    public function add_ads(){
        $this->AuthenLogin();
        return view('admin.Ads.add_ads');
    }
    public function edit_ads($ads_id){
        $this->AuthenLogin();
        $ads = Ads::where('ads_id',$ads_id)->get();
        return view('admin.Ads.edit_ads')->with(compact('ads'));
    }
    public function unactive_ads($ads_id){
        $this->AuthenLogin();
        DB::table('tbl_ads')->where('ads_id',$ads_id)->update(['ads_status'=>1]);
        Session::put('message','kích hoạt  thành công');
        return Redirect::to('all-ads');

    }
    public function active_ads($ads_id){
        $this->AuthenLogin();
        DB::table('tbl_ads')->where('ads_id',$ads_id)->update(['ads_status'=>0]);
        Session::put('message','Ẩn thành công');
        return Redirect::to('all-ads');

    }
    
    public function save_ads(AdsRequests $request){
        $this->AuthenLogin();
        $data = $request->all();
        $get_image = request('ads_image');
      
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/qc', $new_image);

            $ads = new Ads();
            $ads->ads_name = $data['ads_name'];
            $ads->ads_image = $new_image;
            $ads->ads_status = $data['ads_status'];
            $ads->ads_desc = $data['ads_desc'];
            $ads->ads_link = $data['ads_link'];
            $ads->save();
            Session::put('message','Thêm thành công');
            return Redirect::to('add-ads');
        }else{
            Session::put('message','Vui lòng thêm hình ảnh');
            return Redirect::to('add-ads');
        }
        
    }
    public function update_ads(AdsRequests $request,$ads_id){
        $this->AuthenLogin();
        $data = $request->all();
        $get_image = request('ads_image');
      
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/qc', $new_image);

            $ads = Ads::find($ads_id);
            $ads->ads_name = $data['ads_name'];
            $ads->ads_image = $new_image;
            $ads->ads_status = $data['ads_status'];
            $ads->ads_desc = $data['ads_desc'];
            $ads->ads_link = $data['ads_link'];
            $ads->save();
            Session::put('message','Cập Nhập thành công');
            return Redirect::to('all-ads');
        }else{
            Session::put('message','Vui lòng thêm hình ảnh');
            return Redirect::to('all-ads');
        }
        
    }
    public function delete_ads(Request $request, $ads_id){
        $this->AuthenLogin();
        $ads = Ads::find($ads_id);
        $ads_image = $ads->ads_image;
        if ($ads_image) {
            $path = 'upload/qc/'.$ads_image;//đường dẫn
            unlink($path);//xóa hình ảnh bài viết
        }
        $ads->delete();
        Session::put('message','Xóa  thành công');
        return redirect()->back();

    }


}
