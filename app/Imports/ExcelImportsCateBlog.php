<?php

namespace App\Imports;

use App\Models\CateBlog;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
class ExcelImportsCateBlog implements ToModel,WithHeadingRow,WithValidation,SkipsOnFailure
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
        return new CateBlog([
            'cate_blog_name' => $row['cate_blog_name'],
            'cate_blog_desc' => $row['cate_blog_desc'],
            'cate_blog_slug' => $row['cate_blog_slug'],
            'cate_blog_status' => $row['cate_blog_status'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.cate_blog_name' => ['required','max:255'],
            '*.cate_blog_desc' => ['required','max:255'],
            '*.cate_blog_slug' => ['required','max:255'],
            '*.cate_blog_status' => ['required', 'numeric', 'min:0', 'max:1'],
        ];
    }
    public function customValidationMessages()
    {
            return [
                '*.cate_blog_name.required' => 'Vui lòng không để trống !',
                '*.cate_blog_desc.required' => 'Vui lòng không để trống !',
                '*.cate_blog_slug.required' => 'Vui lòng không để trống !',
                '*.cate_blog_status.required' => 'Vui lòng không để trống !',

                '*.cate_blog_name.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.cate_blog_desc.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.cate_blog_slug.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.cate_blog_status.max' => 'Vui lòng không nhập quá 255 ký tự',
                
                 '*.cate_blog_status.numeric' => 'Vui lòng nhập số!',
                 '*.cate_blog_status.min' => 'Vui lòng nhập 0 (ẩn danh mục) hoặc 1 (hiển thị danh mục)',
                 '*.cate_blog_status.max' => 'Vui lòng nhập 0 (ẩn danh mục) hoặc 1 (hiển thị danh mục)',

            ];
    }


}
