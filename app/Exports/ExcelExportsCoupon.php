<?php

namespace App\Exports;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison; //0 giá trị của mình là giá trị thực 0trong trang tính Excel thay vì null(ô trống)


class ExcelExportsCoupon implements FromCollection,ShouldAutoSize,WithHeadings,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() 
    {
        return Coupon::all();
    }
    //Thêm hàng tiêu đề cho bảng
    public function headings() :array {
    	return ["STT","coupon_name", "coupon_qty", "coupon_date_start", "coupon_date_end","coupon_condition","coupon_code","coupon_number","coupon_status"];
    }
}
