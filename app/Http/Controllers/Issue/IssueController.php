<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Traits\ExcelHandle;
use App\Imports\ImportIssues;
use Maatwebsite\Excel\Facades\Excel;

class IssueController extends Controller
{

    use ExcelHandle;

    public function index()
    {
        return view('issue.index')->with('search', '');
    }

    public function show($id)
    {
        return view("issue.show")->withIssue(\App\Issue::findOrFail($id));
    }

    public function search()
    {
        $key = \Request::get('s');
        if(trim($key)==''){
            return back();
        }
        $column = preg_match('/\d{3,}/', $key) ? 'contract_no' : 'collector';
        $data = \App\Issue::where($column, 'like', '%' . $key . '%')->orderBy('result', 'desc');
        $excel = $data->count() > 6000 ? 0 : \Request::get('e');
        $title = ['id', 'date', 'contract_no', 'client_name', 'phone', 'object', 'city', 'region', 'collector', 'employeeID', 'issue_type', 'issue', 'remark', 'responsible_person', 'feedback', 'qc_name', 'result', 'close_reason',
            'callback_id', 'add_time', 'feedback_person', 'feedback_time', 'close_person', 'close_time', 'edit_log', 'source', 'harassment_type', 'upload_time', 'uploader', 'violationRecords', 'deleted_at', 'user_id', 'updated_at','created_at'];
        
        return $excel ? $this->arrayToExcel($data->get()->toArray(), 'issues' . date("Ymd"), $title, 'A2') : view("issue.search")->withIssues($data->paginate(20)->appends(['s' => $key]))->with('search', $key);
    }
    public function upload(){
        return view('issue.upload');
    }
    public function import(){
        try {
            Excel::import(new ImportIssues(), request()->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withErrors($failures);            
        } catch(\Exception $e){
            return back()->withErrors($e->getMessage());
        }      
        return url('issue');
    }

}
