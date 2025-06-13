<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison; //0 giá trị của mình là giá trị thực 0trong trang tính Excel thay vì null(ô trống)


class ExcelExportsBrand implements FromCollection,ShouldAutoSize,WithHeadings,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() 
    {
        return Brand::all();
    }
    //Thêm hàng tiêu đề cho bảng
    public function headings() :array {
    	return ["STT","brand_name", "brand_name_en", "brand_desc", "brand_slug","brand_status"];
    }
}
