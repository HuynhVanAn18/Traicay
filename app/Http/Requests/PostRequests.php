<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'post_title' => 'required|max:255',
        'post_slug' => 'required|max:255',
        'post_image' => 'required|image|file|max:8192',
        'post_keywords' => 'required|max:255',
        'post_meta_desc' => 'required|max:255',

        'post_desc' => 'required',
        'post_content' => 'required',

        ];
    }
    public function messages()
    {
        return [
        'post_title.required' => 'Tên sản không được bỏ trống',
        'post_slug.required' => 'Tên Slug không được bỏ trống',
        'post_image.required' => 'Hình ảnh không được bỏ trống',
        'post_keywords.required' => 'keyword không được bỏ trống',
        'post_desc.required' => 'Mô tả không được bỏ trống',
        'post_meta_desc.required' => 'Meta bài viết không được bỏ trống',
        'post_content.required' => 'Nội dung không được bỏ trống',
       

        'post_image.image' => 'File tải lên phải là file ảnh',
        'post_image.max' => 'Kích thước phải < 8MB',



        'post_title.max' => 'Tên sản không quá 255 ký tự',
        'post_slug.max' => 'Tên Slug không quá 255 ký tự',
        'post_keywords.max' => 'keyword không quá 255 ký tự',
        'post_meta_desc.max' => 'Meta bài viết không quá 255 ký tự',
        ];
    }
}
