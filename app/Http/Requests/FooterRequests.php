<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterRequests extends FormRequest
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
            'contact_info' => 'required',
            'map_info' => 'required',
            'fanpage_info' => 'required',
            'image_info' => 'required',
        ];
    }
     public function messages()
    {
        return [
            'contact_info.required' => 'Thông tin không được bỏ trống',
            'map_info.required' => 'Bản đồ không được bỏ trống',
            'fanpage_info.required' => 'Fanpage không được bỏ trống',
            'image_info.required' => 'Logo không được bỏ trống',

        ];
    }
}
