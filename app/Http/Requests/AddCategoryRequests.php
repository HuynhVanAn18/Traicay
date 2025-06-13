<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequests extends FormRequest
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
            'category_product_name' => 'required|max:255',
            'category_product_name_en' => 'required|max:255',
            'category_slug' => 'required|max:255',
            'category_product_desc' => 'required|max:255',
        ];
    }
     public function messages()
    {
        return [
        'category_product_name.required' => 'Tên danh mục không được bỏ trống',
        'category_product_desc.required' => 'Mô tả danh mục không được bỏ trống',
        'category_product_name_en.required' => 'Tên danh mục tiếng anh không được bỏ trống',
        'category_slug.required' => 'Slug không được bỏ trống',


        'category_product_name.max' => 'Tên danh mục không quá 255 ký tự',
        'category_product_desc.max' => 'Mô tả danh mục không quá 255 ký tự',
        'category_product_name_en.max' => 'Tên danh mục tiếng anh không quá 255 ký tự',
        'category_slug.max' => 'Slug không quá 255 ký tự',
        ];
    }
}
