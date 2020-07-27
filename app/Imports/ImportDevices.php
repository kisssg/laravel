<?php

namespace App\Imports;

use App\Device;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ImportDevices implements ToCollection, WithHeadingRow {

    use Importable;

    /**
     * update collectors device info
     * 
     * @param \App\Imports\Collection $rows
     */
    public function collection(Collection $rows) {
        Validator::make($rows->toArray(), $this->rules(), $this->customValidationMessages())->validate();
        $user=Auth::user()->name;
        foreach ($rows as $row) {
            Device::updateOrCreate(
                    ['employee_id' => $row['employee_id'], 'device' => $row['device']],
                    ['name' => $row['name'], 'status' => $row['status'],
                        'remark' => $row['remark'],
                        'updated_by'=>$user,
            ]);
        }
    }

    public function rules(): array {
        return [
            '*.name' => "required|64", '*.employee_id' => "required|numeric|max:11",
            '*.device' => Rule::in('tablet', 'vrd'), '*.remark' => "required|max:512",
            '*.status' => 'required|max:64',
        ];
    }

    public function customValidationMessages() {
        return [
            '*.required' => ':attribute不能为空',
            '*.unique' => ':attribute已存在',
            '*.max' => ':attribute长度不能超过:max',
            '*.in' => ':attribute不在可选项内：:values',
            "*.numeric" => ":attribute需为数字格式",
            'month_belong.between' => '所属月份格式为:yyyymm 如:201906'
        ];
    }

}
