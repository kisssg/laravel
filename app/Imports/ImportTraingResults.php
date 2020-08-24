<?php

namespace App\Imports;

use App\TrainingTestResult as TrainingResult;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ImportTraingResults implements ToCollection, WithHeadingRow {

    use Importable;

    /**
     * update collectors training test results info
     * 
     * @param \App\Imports\Collection $rows
     */
    public function collection(Collection $rows) {
        Validator::make($rows->toArray(), $this->rules(), $this->customValidationMessages())->validate();
        $user=Auth::user()->name;
        foreach ($rows as $row) {
            TrainingResult::updateOrCreate(
                    ['employee_id' => $row['employee_id'], 'training_date' => $row['training_date'],
                        'training_type' => $row['training_type']],
                    ['name_cn' => $row['name_cn'], 'region' => $row['region'],
                        'business_score'=>$row['business_score'],
                        'much_score'=>$row['much_score'],
                        'vrd_score'=>$row['vrd_score'],
                        'phone_score'=>$row['phone_score'],
                        'general_score'=>$row['general_score'],
                        'oral_score'=>$row['oral_score'],
                        'coc_score'=>$row['coc_score'],          
                        'remark'=>$row['remark'],
                        'updated_by'=>$user,
            ]);
        }
    }

    public function rules(): array {
        return [
            '*.training_date' => "required|date", '*.employee_id' => "required|numeric|digits_between:5,11",
            '*.training_type' => "required",'*.general_score' => 'required|numeric',
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
