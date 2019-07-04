<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Violation;

use App\Violation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportViolations;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller controls requests relevant to violations
 * @author Sucre.xu
 */
class ViolationController extends Controller
{

    use \App\Traits\ExcelHandle;

    public function index()
    {
        return view('violation.index')->with('search', '');
    }

    public function show($id)
    {
        return view('violation.show')->withViolation(\App\Violation::findOrfail($id));
    }

    /**
     * search 
     * @return view|excel
     */
    public function search()
    {
        $key = \Request::get('s');
        if (trim($key) == '')
        {
            return back();
        }
        $column = preg_match('/\d{3,}/', $key) ? 'contract_no' : 'name_lli';
        $data = \App\Violation::where($column, 'like', '%' . $key . '%');
        $excel = $data->count() > 6000 ? 0 : \Request::get('e');
        $title = ['id', 'channel', 'issue_id', 'contract_no', 'issue_type', 'issue', 'remark', 'cash_collect_amt', 'city_en', 'region', 'name_lli', 'employee_id', 'name_tl', 'name_sv', 'lcs', 'month_violation', 'date_violation', 'month_propose_action', 'date_propose_action', 'month_decided_action', 'date_decided action', 'month_executed_disciplinary', 'date_executed_disciplinary', 'month_verify_disciplinary', 'date_verify_disciplinary', 'who_detected', 'who_proposed_disciplinary', 'who_decide_disciplinary', 'who_execute_disciplinary', 'who_verify_disciplinary', 'source', 'harasment_type', 'punishment_proposed', 'punishment_decided', 'comment', 'month_belong', 'user_id', 'creat_time', 'creat_date', 'edit_time', 'edit_date', 'edit_log', 'punish_records', 'deleted_at', 'updated_at', 'created_at'];

        return $excel ? $this->arrayToExcel($data->get()->toArray(), 'violations' . date("Ymd"), $title, 'A2') : view("violation.search")->withViolations($data->paginate(20)->appends(['s' => $key]))->with('search', $key);
    }

    public function create()
    {
        return ('violation.create');
    }

    public function store(Request $request)
    {
        $rules = [];
        $this->validate($request, $rules);
        $violation = new Violation;
        $violation->issue = $request->get('issue');
        //...
        if ($violation->save())
        {
            return redirect('violation.violations');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors('保存失败Failed saving!');
        }
    }

    public function upload()
    {
        return view('violation.upload');
    }

    public function import()
    {
        try {
            Excel::import(new ImportViolations(), request()->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withErrors($failures);
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            return back()->withErrors('文件大小超限');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return url('violation');
    }

    public function edit()
    {
        return 'edit';
    }

    public function update()
    {
        return 'put';
    }

    public function destroy()
    {
        
    }

}
