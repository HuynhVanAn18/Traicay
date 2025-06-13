<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequests extends FormRequest
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
        'product_name' => 'required|max:255',
        'product_price' => 'required|regex:/^\d+(\.\d{0})?$/|max:255',
        'product_image' => 'required|image|file|max:8192',
        'product_desc' => 'required|max:255',
        'product_content' => 'required|max:255',

        'product_name_en' => 'required|max:255',
        'product_slug' => 'required|max:255',
        'product_qty' => 'required|regex:/^\d+(\.\d{0})?$/|max:255',
        'product_content_en' => 'required|max:255',
        'product_cate' => 'required',
        'product_brand' => 'required',


        ];
    }
    public function messages()
    {
        return [
        'product_name.required' => 'Tên sản phẩm không được bỏ trống',

        'product_name_en.required' => 'Tên sản phẩm tiếng anh không được bỏ trống',
        'product_slug.required' => 'Tên Slug không được bỏ trống',
        'product_qty.required' => 'Số lượng sản phẩm không được bỏ trống',
        'product_content_en.required' => 'Nội dung sản phẩm tiếng anh không được bỏ trống',
        'product_cate.required' => 'Danh Mục không được bỏ trống',
        'product_brand.required' => 'Thương hiệu không được bỏ trống',

        'product_price.required' => 'Giá sản phẩm không được bỏ trống',
        'product_image.required' => 'Hình ảnh sản phẩm không được bỏ trống',
        'product_desc.required' => 'Mô tả sản phẩm không được bỏ trống',
        'product_content.required' => 'Nội sản phẩm dung không được bỏ trống',

        'product_image.image' => 'File tải lên phải là file ảnh',
        'product_image.max' => 'Kích thước phải < 8MB',

        'product_price.regex' => 'Tiền không đúng định dạng, phải là số, không ký tự, VD: 500000 => đúng định dạng',
        'product_qty.regex' => 'Số lượng không đúng định dạng',

        'product_name.max' => 'Tên sản phẩm không quá 255 ký tự', 
        'product_name_en.max' => 'Tên sản phẩm tiếng anh không quá 255 ký tự',
        'product_slug.max' => 'Tên Slug không quá 255 ký tự',
        'product_qty.max' => 'Số lượng sản phẩm không quá 255 ký tự',
        'product_content_en.max' => 'Nội dung sản phẩm tiếng anh không quá 255 ký tự',
        'product_price.max' => 'Giá sản phẩm không quá 255 ký tự',
        'product_desc.max' => 'Mô tả sản phẩm không quá 255 ký tự',
        'product_content.max' => 'Nội sản phẩm dung sản phẩm không quá 255 ký tự',
        ];
    }
}
