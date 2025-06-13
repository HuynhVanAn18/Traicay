<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBrandRequests extends FormRequest
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
            'brand_product_name' => 'required|max:255',
            'brand_product_name_en' => 'required|max:255',
            'brand_slug' => 'required|max:255',
            'brand_product_desc' => 'required|max:255',
        ];
    }
     public function messages()
    {
        return [
            'brand_product_name.required' => 'Tên thương hiệu không được bỏ trống',
            'brand_product_name_en.required' => 'Tên thương hiệu không được bỏ trống',
            'brand_slug.required' => ' Slug không được bỏ trống',
            'brand_product_desc.required' => 'Mô tả không được bỏ trống',


            'brand_product_name.max' => 'Tên thương hiệu không quá 255 ký tự',
            'brand_product_name_en.max' => 'Tên thương hiệu không quá 255 ký tự',
            'brand_slug.max' => ' Slug không quá 255 ký tự',
            'brand_product_desc.max' => 'Mô tả không quá 255 ký tự',
        ];
    }
}
