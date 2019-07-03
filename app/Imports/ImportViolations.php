<?php

namespace App\Imports;

use App\Violation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;

class ImportViolations implements ToModel, WithHeadingRow, WithValidation
{

    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!isset($row['channel']) || !array_key_exists("channel", $row))
        {
            throw new \Exception('确认列channel是否存在');
        }
        return new Violation([
            'channel' => $row['channel'],
            'issue_id' => $row['issue_id'],
            'contract_no' => $row['contract_no'],
            'issue_type' => $row['issue_type'],
            'issue' => $row['issue'],
            'remark' => $row['remark'],
            'cash_collect_amt' => $row['cash_collect_amt'],
            'city_en' => $row['city_en'],
            'region' => $row['region'],
            'name_lli' => $row['name_lli'],
            'employee_id' => $row['employee_id'],
            'name_tl' => $row['name_tl'],
            'name_sv' => $row['name_sv'],
            'lcs' => $row['lcs'],
            'month_violation' => $row['month_violation'],
            'date_violation' => $row['date_violation'],
            'month_propose_action' => $row['month_propose_action'],
            'date_propose_action' => $row['date_propose_action'],
            'month_decided_action' => $row['month_decided_action'],
            'date_decided action' => $row['date_decided_action'],
            'month_executed_disciplinary' => $row['month_executed_disciplinary'],
            'date_executed_disciplinary' => $row['date_executed_disciplinary'],
            'month_verify_disciplinary' => $row['month_verify_disciplinary'],
            'date_verify_disciplinary' => $row['date_verify_disciplinary'],
            'who_detected' => $row['who_detected'],
            'who_proposed_disciplinary' => $row['who_proposed_disciplinary'],
            'who_decide_disciplinary' => $row['who_decide_disciplinary'],
            'who_execute_disciplinary' => $row['who_execute_disciplinary'],
            'who_verify_disciplinary' => $row['who_verify_disciplinary'],
            'source' => $row['source'],
            'harassment_type' => $row['harassment_type'],
            'punishment_proposed' => $row['punishment_proposed'],
            'punishment_decided' => $row['punishment_decided'],
            'comment' => $row['comment'],
            'month_belong' => $row['month_belong'],
        ]);
    }

    public function rules(): array
    {
        return [
            'issue_id' => 'required|unique:violations|max:10',
            'month_belong' => 'required|between:6,6',
            'channel' => Rule::in('Field', 'Agency'),
        ];
    }

    public function customValidationMessages()
    {
        return [
            'issue_id.required' => 'issue_id不能为空',
            'issue_id.unique' => 'issue_id已存在',
            'issue_id.max' => 'issue_id长度不能超过:max',
            'channel.in' => 'channel需为Field或Agency',
            'month_belong.required' => '所属月份必须填写',
            'month_belong.between' => '所属月份格式为:yyyymm 如:201906'
        ];
    }

}
