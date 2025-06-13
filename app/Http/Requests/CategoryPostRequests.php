<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryPostRequests extends FormRequest
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
            'cate_blog_name' => 'required|max:255',
            'cate_blog_slug' => 'required|max:255',
            'cate_blog_desc' => 'required|max:255',
        ];
    }
     public function messages()
    {
        return [
            'cate_blog_name.required' => 'Tên danh mục bài viết không được bỏ trống',
            'cate_blog_slug.required' => 'Tên Slug danh mục bài viết không được bỏ trống',
            'cate_blog_desc.required' => ' Mô tả không được bỏ trống',


            'cate_blog_name.max' => 'Tên danh mục bài viết không quá 255 ký tự',
            'cate_blog_slug.max' => 'Tên Slug danh mục bài viết không quá 255 ký tự',
            'cate_blog_desc.max' => ' Mô tả không quá 255 ký tự',

        ];
    }
}
