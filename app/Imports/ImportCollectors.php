<?php

namespace App\Imports;

use App\Violation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;

class ImportCollectors implements ToModel, WithHeadingRow, WithValidation
{

    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Collector(['name_cn', 'area', 'city', 'position', 'name_en', 'employee_id',
            'onboard_date', 'email', 'province', 'city_cn', 'tl', 'sv', 'manager', 'type', 'status',
            'phone_number', 'cfc_hm_id', 'gc_hm_id', 'person_id', 'district',
        ]);
    }

    public function rules(): array
    {
        return [
            'name_cn' => "required", 'area' => "required", 'city' => "required", 'position' => "required", 'name_en' => "required", 'employee_id' => "required",
            'onboard_date' => "", 'email' => "email|required", 'province' => "", 'city_cn' => "", 'tl' => "", 'sv' => '', 'manager' => '', 'type' => Rule::in('lli', 'agency'),
            'status' => Rule::in('intern', 'on-job', 'departured'), 'phone_number' => '', 'cfc_hm_id' => 'required|unique:fc_employees', 'gc_hm_id' => '', 'person_id' => 'unique:fc_employees', 'district' => '',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.required' => ':attribute不能为空',
            '*.unique' => ':attribute已存在',
            '*.max' => ':attribute长度不能超过:max',
            '*.in' => ':attribute不在可选项内：:values',
            'month_belong.between' => '所属月份格式为:yyyymm 如:201906'
        ];
    }

}
