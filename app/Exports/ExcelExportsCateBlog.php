<?php

namespace App\Exports;

use App\Models\CateBlog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison; //0 giá trị của mình là giá trị thực 0trong trang tính Excel thay vì null(ô trống)


class ExcelExportsCateBlog implements FromCollection,ShouldAutoSize,WithHeadings,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() 
    {
        return CateBlog::all();
    }
    //Thêm hàng tiêu đề cho bảng
    public function headings() :array {
    	return ["STT","cate_blog_name", "cate_blog_desc", "cate_blog_slug","cate_blog_status"];
    }
}
