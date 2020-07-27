<?php

namespace App\Imports;

use App\Payment;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ImportPayments implements ToCollection, WithHeadingRow {

    use Importable; 
    /**
     * update specific collector distinguished by employee ID, if not exist, create one.
     * 
     * @param \App\Imports\Collection $rows
     */
    public function collection(Collection $rows) {
        Validator::make($rows->toArray(), $this->rules(), $this->customValidationMessages())->validate();
        $user=Auth::user()->name;
        foreach ($rows as $row) {
            Payment::updateOrCreate(["employee_id" => $row['employee_id'], "year" => $row['year'], 'month' => $row['month']],
                            [
                                'NAME_COLLECTOR' => $row['name_collector'],
                                'COUNT_CONTRACT' => $row['count_contract'],
                                'PAYMENT' => $row['payment'],
                                'ASSIGN_AMT' => $row['assign_amt'],
                                'updated_by'=> $user,
            ]);
        }
    }

    public function rules(): array {
        return [
            '*.name_collector' => "required|max:32",
            '*.count_contract' => "required|digits_between:1,11",
            '*.payment' => "required|digits_between:1,11",
            '*.assign_amt' => "required|digits_between:1,11",
            '*.year'=>"required|digits:4",
            '*.month'=>"required|digits:6"];
    }

    public function customValidationMessages() {
        return [
            '*.required' => ':attribute不能为空',
            '*.unique' => ':attribute已存在',
            '*.max' => ':attribute长度不能超过:max',
            '*.in' => ':attribute不在可选项内：:values',
            "*.numeric" => ":attribute需为数字格式",
            '*.digits'=>":attribute需为:value位数字",
            '*.digits_between'=>":attribute需为:min到:max位数字",
            'month.digits' => '月份格式需为:yyyymm 如:201906'
        ];
    }
}
