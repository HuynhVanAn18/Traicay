<?php

namespace App\Imports;

use App\Models\Category;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
class ExcelImports implements ToModel,WithHeadingRow,WithValidation,SkipsOnFailure
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
        return new Category([
            'category_name' => $row['category_name'],
            'category_name_en' => $row['category_name_en'],
            'category_desc' => $row['category_desc'],
            'category_slug' => $row['category_slug'],
            'category_status' => $row['category_status'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.category_name' => ['required','max:255'],
            '*.category_name_en' => ['required','max:255'],
            '*.category_desc' => ['required','max:255'],
            '*.category_slug' => ['required','max:255'],
            '*.category_status' => ['required', 'numeric', 'min:0', 'max:1'],
        ];
    }
    public function customValidationMessages()
    {
            return [
                '*.category_name.required' => 'Vui lòng không để trống !',
                '*.category_name_en.required' => 'Vui lòng không để trống !',
                '*.category_desc.required' => 'Vui lòng không để trống !',
                '*.category_slug.required' => 'Vui lòng không để trống !',
                '*.category_status.required' => 'Vui lòng không để trống !',

                '*.category_name.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.category_name_en.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.category_desc.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.category_slug.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.category_status.max' => 'Vui lòng không nhập quá 255 ký tự',
                
                 '*.category_status.numeric' => 'Vui lòng nhập số!',
                 '*.category_status.min' => 'Vui lòng nhập 0 (ẩn danh mục) hoặc 1 (hiển thị danh mục)',
                 '*.category_status.max' => 'Vui lòng nhập 0 (ẩn danh mục) hoặc 1 (hiển thị danh mục)',

            ];
    }


}
