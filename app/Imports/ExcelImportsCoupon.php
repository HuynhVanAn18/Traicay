<?php


namespace App\Imports;

use App\Models\Coupon;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ExcelImportsCoupon implements ToModel,WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow() : int
    {
        return 1;
    }
    public function model(array $row)
    {
        return new Coupon([
            'coupon_name' => $row['coupon_name'],   
            'coupon_qty' => $row['coupon_qty'],
            'coupon_date_start' => $row['coupon_date_start'],   
            'coupon_date_end' => $row['coupon_date_end'],
            'coupon_condition' => $row['coupon_condition'],  
            'coupon_code' => $row['coupon_code'],      
            'coupon_number' => $row['coupon_number'],   
            'coupon_status' => $row['coupon_status'],   
        ]);
    }

    public function rules(): array
    {
        return [
            '*.coupon_name' => ['required'],
            '*.coupon_qty' => ['required', 'numeric'],
            '*.coupon_date_start' => ['required', 'date_format:d/m/Y'],
            '*.coupon_date_end' => ['required', 'date_format:d/m/Y'],
            '*.coupon_condition' => ['required', 'numeric', 'min:0', 'max:1'],
            '*.coupon_code' => ['required', 'unique:tbl_coupon'],
            '*.coupon_number' => ['required', 'numeric'],
            '*.coupon_status' => ['required', 'numeric', 'min:0', 'max:1'],
        ];
    }

    public function customValidationMessages()
    {
            return [
                '*.coupon_name.required' => 'Vui lòng không để trống !',

                '*.coupon_qty.required' => 'Vui lòng không để trống !',
                '*.coupon_qty.numeric' => 'Vui lòng nhập số!',

                '*.coupon_number.required' => 'Vui lòng không để trống !',
                '*.coupon_number.numeric' => 'Vui lòng nhập số!',

                '*.coupon_code.required' => 'Vui lòng không để trống !',
                '*.coupon_code.unique' => 'Mã đã được sử dụng',

                '*.coupon_condition.required' => 'Vui lòng không để trống !',
                '*.coupon_condition.numeric' => 'Vui lòng nhập số!',
                '*.coupon_condition.min' => 'Vui lòng nhập 0 (phần trăm) hoặc 1 (tiền)',
                '*.coupon_condition.max' => 'Vui lòng nhập 0 (phần trăm) hoặc 1 (tiền)',

                '*.coupon_date_start.required' => 'Vui lòng không để trống !',
                '*.coupon_date_start.date_format' => 'Ngày không khớp với định dạng d/m/Y',

                '*.coupon_date_end.required' => 'Vui lòng không để trống!',
                '*.coupon_date_end.date_format' => 'Ngày không khớp với định dạng d/m/Y',


                '*.coupon_status.required' => 'Vui lòng không để trống !',
                '*.coupon_status.numeric' => 'Vui lòng nhập số !',
                '*.coupon_status.min' => 'Vui lòng nhập 0 (Hiện) hoặc 1 (Ẩn)',
                '*.coupon_status.max' => 'Vui lòng nhập 0 (Hiện) hoặc 1 (Ẩn)',
            ];
    }


}
