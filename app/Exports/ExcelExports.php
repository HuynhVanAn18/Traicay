<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison; //0 giá trị của mình là giá trị thực 0trong trang tính Excel thay vì null(ô trống)


class ExcelExports implements FromCollection,ShouldAutoSize,WithHeadings,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() 
    {
        return Category::all();
    }
    //Thêm hàng tiêu đề cho bảng
    public function headings() :array {
    	return ["STT","category_name", "category_name_en", "category_desc", "category_slug","category_status"];
    }
}
