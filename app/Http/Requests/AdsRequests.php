<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequests extends FormRequest
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
            'ads_name' => 'required|max:255',
            'ads_desc' => 'required|max:255',
            'ads_image' => 'required',
            'ads_link' => 'required|max:255',

        ];
    }
     public function messages()
    {
        return [
            'ads_name.required' => 'Tên quảng cáo không được bỏ trống',
            'ads_desc.required' => 'Mô tả quảng cáo không được bỏ trống',
            'ads_image.required' => 'Hình ảnh quảng cáo không được bỏ trống',
            'ads_link.required' => 'Link quảng cáo không được bỏ trống',


            'ads_name.max' => 'Tên quảng cáo không quá 255 ký tự',
            'ads_desc.max' => ' Mô tả không quá 255 ký tự',
            'ads_link.max' => ' Link không quá 255 ký tự',

        ];
    }
}
