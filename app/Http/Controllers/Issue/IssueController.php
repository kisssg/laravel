<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Traits\ExcelHandle;
use App\Imports\ImportIssues;
use Maatwebsite\Excel\Facades\Excel;
use App\Issue;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class IssueController extends Controller
{

    use ExcelHandle;
    use SendsPasswordResetEmails;
    
    protected $exceltTitle=['id', 'date', 'contract_no', 'client_name', 'phone', 'object', 'city', 'region', 'collector', 'employeeID', 'issue_type', 'issue', 'remark', 'responsible_person', 'feedback', 'qc_name', 'result', 'close_reason',
            'callback_id', 'add_time', 'feedback_person', 'feedback_time', 'close_person', 'close_time', 'edit_log', 'source', 'harassment_type', 'upload_time', 'uploader', 'violationRecords', 'deleted_at', 'user_id', 'updated_at', 'created_at'];


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
        if (trim($key) == '')
        {
            return back();
        }
        if(preg_match('/^(log:)(.+)/',$key,$matches)){
            return $this->searchThroughEditLog($matches[2]);
        }                
        $column = preg_match('/\d{3,}/', $key) ? 'contract_no' : 'collector';
        return $this->searchColumn($column, $key);
        }
    protected function searchColumn($column,$key,$wholeKey=null){
        if($wholeKey==null){
            $wholeKey=$key;
        }
        $data = \App\Issue::where($column, 'like', '%' . $key . '%')->orderBy('result', 'desc');
        $excel = $data->count() > 6000 ? 0 : \Request::get('e');        
        return $excel ? $this->arrayToExcel($data->get()->toArray(), 'issues' . date("Ymd"), $this->exceltTitle, 'A2') : view("issue.search")->withIssues($data->paginate(20)->appends(['s' => $wholeKey]))->with('search', $wholeKey);
    
    }
    public function searchThroughEditLog($editLog){
        return $this->searchColumn("edit_log",$editLog,"log:".$editLog);
    }

    public function upload()
    {
        return view('issue.upload');
    }

    public function import()
    {
        try {
            Excel::import(new ImportIssues(), request()->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withErrors($failures);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect('issue');
    }

    public function generateViolations($date)
    {
        /*
         * select issues meet below rules:
         * 1. result confirm valid
         * 2. object is LLI or agency
         * 3. issue type should be attitude or mistake
         */
        $issues = Issue::where('result', '=', '有效')
                        ->whereIn('object', ['外包公司', '外催员/法律调查员'])
                        ->whereIn('issue_type', ['Collector\'s attitude 催收员态度', 'Collector\'s mistake 催收员过错'])
                        ->where('date', '=', $date)->paginate(10);
        return view('test')->withTest($issues);
    }

    public function test()
    {

    }

}
