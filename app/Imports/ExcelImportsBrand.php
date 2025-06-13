<?php

namespace App\Imports;

use App\Models\Brand;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
class ExcelImportsBrand implements ToModel,WithHeadingRow,WithValidation,SkipsOnFailure
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
        return new brand([
            'brand_name' => $row['brand_name'],
            'brand_name_en' => $row['brand_name_en'],
            'brand_desc' => $row['brand_desc'],
            'brand_slug' => $row['brand_slug'],
            'brand_status' => $row['brand_status'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.brand_name' => ['required','max:255'],
            '*.brand_name_en' => ['required','max:255'],
            '*.brand_desc' => ['required','max:255'],
            '*.brand_slug' => ['required','max:255'],
            '*.brand_status' => ['required', 'numeric', 'min:0', 'max:1'],
        ];
    }
    public function customValidationMessages()
    {
            return [
                '*.brand_name.required' => 'Vui lòng không để trống !',
                '*.brand_name_en.required' => 'Vui lòng không để trống !',
                '*.brand_desc.required' => 'Vui lòng không để trống !',
                '*.brand_slug.required' => 'Vui lòng không để trống !',
                '*.brand_status.required' => 'Vui lòng không để trống !',

                '*.brand_name.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.brand_name_en.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.brand_desc.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.brand_slug.max' => 'Vui lòng không nhập quá 255 ký tự',
                '*.brand_status.max' => 'Vui lòng không nhập quá 255 ký tự',
                
                 '*.brand_status.numeric' => 'Vui lòng nhập số!',
                 '*.brand_status.min' => 'Vui lòng nhập 0 (ẩn danh mục) hoặc 1 (hiển thị danh mục)',
                 '*.brand_status.max' => 'Vui lòng nhập 0 (ẩn danh mục) hoặc 1 (hiển thị danh mục)',

            ];
    }


}
