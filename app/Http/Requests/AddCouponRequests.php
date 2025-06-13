<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AddCouponRequests extends FormRequest
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

            'coupon_name' => 'required|max:255',
            'coupon_code' => 'required|max:255',
            'coupon_qty' => 'required|max:11|regex:/^\d+(\.\d{0})?$/|',
            'coupon_date_start' => 'required|max:100',
            'coupon_date_end' => 'required|max:100',
            'coupon_number' => 'required|max:11|regex:/^\d+(\.\d{0})?$/',

        ];
    }
     public function messages()
    {
        return [
            'coupon_name.required' => 'Tên mã giảm giá không được bỏ trống',
            'coupon_code.required' => 'Mã giảm giá không được bỏ trống',
            'coupon_qty.required' => 'Số lượng mã không được bỏ trống',
            'coupon_date_start.required' => 'Ngày bắt đầu không được bỏ trống',
            'coupon_date_end.required' => 'Ngày kết thúc không được bỏ trống',
            'coupon_number.required' => 'Số tiền giảm giá không được bỏ trống',

            'coupon_name.max' => 'Tên mã giảm giá không quá 255 ký tự',
            'coupon_code.max' => 'Mã giảm giá không quá 255 ký tự',
            'coupon_qty.max' => 'Số lượng mã không quá 11 ký tự',
            'coupon_date_start.max' => 'Ngày bắt đầu không quá 100 ký tự',
            'coupon_date_end.max' => 'Ngày kết thúc không quá 100 ký tự',
            'coupon_number.max' => 'Số tiền giảm giá không quá 11 ký tự',
           
            'coupon_qty.regex' => 'Số lượng không đúng vui lòng nhập lại',
            'coupon_number.regex' => 'Tiền không đúng định dạng, phải là số, không ký tự, VD: 500000 => đúng định dạng',
        ];
    }
}
