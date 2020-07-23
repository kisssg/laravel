<?php

namespace App\Imports;

use App\Collector;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ImportCollectors implements ToCollection, WithHeadingRow
{
    use Importable;

   /**
    * update specific collector distinguished by employee ID, if not exist, create one.
    * 
    * @param \App\Imports\Collection $rows
    */
    public function collection(Collection $rows){
        Validator::make($rows->toArray(), $this->rules(),$this->customValidationMessages())->validate();
        foreach($rows as $row){
             Collector::updateOrCreate(['employee_id' => $row['employee_id']],['name_cn' => $row['name_cn'],
            'area' => $row['area'],
            'city' => $row['city'],
            'position' => $row['position'],
            'name_en' => $row['name_en'],            
            'onboard_date' => $row['onboard_date'],
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'cfc_hm_id' => $row['cfc_hm_id'],
            'gc_hm_id' => $row['gc_hm_id'],
            'person_id' => $row['person_id'],
            'district' => $row['district'],
            'province' => $row['province'],
            'city_cn' => $row['city_cn'],
            'tl' => $row['tl'],
            'sv' => $row['sv'],
            'manager' => $row['manager'],
            'last_date' => $row['last_date'],
            'action_type' => $row['action_type'],
            'action_reason' => $row['action_reason'],
            'type' => $row['type'],
            'status' => $row['status'],
        ]);
        }
    }
    public function model(array $row)
    {
        return new Collector(
                ['name_cn' => $row['name_cn'],
            'area' => $row['area'],
            'city' => $row['city'],
            'position' => $row['position'],
            'name_en' => $row['name_en'],
            'employee_id' => $row['employee_id'],
            'onboard_date' => $row['onboard_date'],
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'cfc_hm_id' => $row['cfc_hm_id'],
            'gc_hm_id' => $row['gc_hm_id'],
            'person_id' => $row['person_id'],
            'district' => $row['district'],
            'province' => $row['province'],
            'city_cn' => $row['city_cn'],
            'tl' => $row['tl'],
            'sv' => $row['sv'],
            'manager' => $row['manager'],
            'last_date' => $row['last_date'],
            'action_type' => $row['action_type'],
            'action_reason' => $row['action_reason'],
            'type' => $row['type'],
            'status' => $row['status'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name_cn' => "required", '*.area' => "required", '*.city' => "required", '*.position' => "required", '*.name_en' => "required", '*.employee_id' => "required|numeric",
            '*.onboard_date' => "", '*.email' => "email|required", '*.province' => "", '*.city_cn' => "", '*.tl' => "", '*.sv' => '', '*.manager' => '', '*.type' => Rule::in('lli', 'agency'),
            '*.status' => Rule::in('intern', 'on-job', 'departured'), '*.phone_number' => '', '*.cfc_hm_id' => 'required|numeric', '*.gc_hm_id' => '', '*.district' => '',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.required' => ':attribute不能为空',
            '*.unique' => ':attribute已存在',
            '*.max' => ':attribute长度不能超过:max',
            '*.in' => ':attribute不在可选项内：:values',
            "*.numeric"=>":attribute需为数字格式",
            'month_belong.between' => '所属月份格式为:yyyymm 如:201906'
        ];
    }

}
