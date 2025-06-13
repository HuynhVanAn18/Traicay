<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequests extends FormRequest
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
            'slider_name' => 'required|max:255',
            'slider_image' => 'required',
            'slider_desc' => 'required|max:255',
        ];
    }
     public function messages()
    {
        return [
            'slider_name.required' => 'Tên Slider không được bỏ trống',
            'slider_image.required' => 'Ảnh Slider không được bỏ trống',
            'slider_desc.required' => ' Mô tả Slider không được bỏ trống',

            'slider_name.unique' => 'Tên Slider đã được sử dụng',

            'slider_name.max' => 'Tên Slider không quá 255 ký tự',
            'slider_desc.max' => ' Mô tả không quá 255 ký tự',

        ];
    }
}
