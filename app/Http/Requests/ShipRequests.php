<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipRequests extends FormRequest
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

            'city' => 'required',
            'province' => 'required',
            'fee_ship' => 'required|max:11|regex:/^\d+(\.\d{0})?$/|',

        ];
    }
     public function messages()
    {
        return [
            'city.required' => 'Thành Phố không được bỏ trống',
            'province.required' => 'Quận/Huyện không được bỏ trống',
            'fee_ship.required' => 'Phí ship không được bỏ trống',
            'fee_ship.regex' => 'Tiền không đúng định dạng, phải là số, không ký tự, VD: 500000 => đúng định dạng',
        ];
    }
}
