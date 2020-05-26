<?php

namespace App\Imports;

use App\Issue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;

class ImportIssues implements ToModel, WithHeadingRow, WithValidation
{

    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Issue([
            'date' => $row['date'],
            'contract_no' => $row['contract_no'],
            'client_name' => $row['client_name'],
            'phone' => $row['phone'],
            'object' => $row['object'],
            'city' => $row['city'],
            'region' => $row['region'],
            'collector' => $row['collector'],
            'employeeID' => $row['employeeid'],
            'issue_type' => $row['issue_type'],
            'issue' => $row['issue'],
            'issue_detail' => $row['issue_detail'],
            'remark' => $row['remark'],
            'responsible_person' => $row['responsible_person'],
            'feedback' => $row['feedback'],
            'qc_name' => $row['qc_name'],
            'result' => $row['result'],
            'close_reason' => $row['close_reason'],
            'callback_id' => $row['callback_id'],
            'add_time' => $row['add_time'],
            'feedback_person' => $row['feedback_person'],
            'close_person' => $row['close_person'],
            'close_time' => $row['close_time'],
            'edit_log' => $row['edit_log'],
            'source' => $row['source'],
            'harassment_type' => $row['harassment_type'],
            'uploader' => $row['uploader'],
        ]);
    }

    public function rules(): array
    {
        return [
            'date' => 'required|max:10|regex:/^\d{4}\-\d{2}\-\d{2}$/',
            'contract_no' => 'required|between:6,14',
            'object' => Rule::in('外催员/法律调查员', '前期催收人员', '业务人员', '外包公司', '无法确定','债权公司'),
            'add_time'=>'regex:/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/',
            'close_time'=>'regex:/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/',
            'uploader'=>'required|max:20',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.required' => ':attribute不能为空',
            '*.max' => ':attribute长度不能超过:max',
            '*.regex'=>':attribute格式不符合要求',
            '*.between'=>':attribute长度需为:min-:max之间',
            '*.regex'=>':attribute不符合格式要求',
            '*.in' => ':attribute不在允许输入选项内::values',
        ];
    }

}
