<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequests extends FormRequest
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
            'order_id' => 'required',
            'amount' => 'required',
            'order_desc' => 'required',
            'bank_code' => 'required',
        ];
    }
     public function messages()
    {
        return [
            'order_id.required' => 'Mã đơn hàng không được bỏ trống',
            'amount.required' => 'Tổng Tiền không được bỏ trống',
            'order_desc.required' => 'Nội dung không được bỏ trống',
            'bank_code.required' => 'Ngân hàng không được bỏ trống',

        ];
    }
}
