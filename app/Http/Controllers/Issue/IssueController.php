<?php

namespace App\Http\Controllers\Issue;

use App\Http\Controllers\Controller;
use App\Traits\ExcelHandle;
use App\Imports\ImportIssues;
use Maatwebsite\Excel\Facades\Excel;
use App\Issue;
use App\Violation;
use App\Collector;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class IssueController extends Controller {

    use ExcelHandle;
    use SendsPasswordResetEmails;

    protected $exceltTitle = ['id', 'date', 'contract_no', 'client_name', 'phone', 'object', 'city', 'region', 'collector', 'employeeID', 'issue_type', 'issue', 'issue_detail', 'remark', 'responsible_person', 'feedback', 'qc_name', 'result', 'close_reason',
        'callback_id', 'add_time', 'feedback_person', 'feedback_time', 'close_person', 'close_time', 'edit_log', 'source', 'harassment_type', 'upload_time', 'uploader', 'violationRecords', 'deleted_at', 'updated_at', 'created_at'];

    public function index() {
        return view('issue.index');
    }

    public function show($id) {
        return view("issue.show")->withIssue(\App\Issue::findOrFail($id));
    }

    public function search() {
        $key = \Request::get('s');
        if (trim($key) == '') {
            return back();
        }
        if (preg_match('/^(log:)(.+)/', $key, $matches)) {
            return $this->searchThroughEditLog($matches[2]);
        }
        if (preg_match('/\[.+?\:.+?\]/', $key)) {
            return $this->searchMultiple($key);
        }
        $column = preg_match('/\d{3,}/', $key) ? 'contract_no' : 'collector';
        return $this->searchColumn($column, $key);
    }

    protected function searchMultiple($key) {
        $matches = [];
        preg_match_all('/\[(.+?)\:(.+?)\]/', $key, $matches);
        $data = \App\Issue::where(function($query) use($matches) {
                    for ($i = 0; $i < count($matches[1]); $i++) {
                        if (Schema::hasColumn('fc_issue', $matches[1][$i])) {
                            $query->where($matches[1][$i], $matches[2][$i]);
                        }
                    }
                })->orderBy('result','desc')->orderBy('date','desc');
        $excel = $data->count() > 6000 ? 0 : \Request::get('e');
        return $excel ? $this->arrayToExcel($data->get()->toArray(), 'issues' . date("Ymd"), $this->exceltTitle, 'A2') : view("issue.search")->withIssues($data->paginate(20)->appends(['s' => $key]))->with('search', $key);
    }

    protected function searchColumn($column, $key, $wholeKey = null) {
        if ($wholeKey == null) {
            $wholeKey = $key;
        }
        $data = \App\Issue::where($column, 'like', '%' . $key . '%')->orderBy('result', 'desc');
        $excel = $data->count() > 6000 ? 0 : \Request::get('e');
        return $excel ? $this->arrayToExcel($data->get()->toArray(), 'issues' . date("Ymd"), $this->exceltTitle, 'A2') : view("issue.search")->withIssues($data->paginate(20)->appends(['s' => $wholeKey]))->with('search', $wholeKey);
    }

    public function searchThroughEditLog($editLog) {
        return $this->searchColumn("edit_log", $editLog, "log:" . $editLog);
    }

    public function upload() {
        return view('issue.upload');
    }

    public function import() {
        try {
            Excel::import(new ImportIssues(), request()->file('file'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            return back()->withErrors('文件大小超限');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect('issue');
    }

    public function generateViolations() {
        /*
         * select issues meet below rules:
         * 1. result confirm valid
         * 2. object is LLI or agency
         * 3. issue type should be attitude or mistake
         */
        $startDate = \Request::get('startDate');
        $endDate = \Request::get('endDate');
        $objects = \Request::get('objects');
        $issues = Issue::where('result', '=', '有效')
                        ->whereIn('object', $objects)
                        ->whereIn('issue_type', ['Collector\'s attitude 催收员态度', 'Collector\'s mistake 催收员过错'])
                        ->whereBetween('close_time', [$startDate, $endDate])->get();
        return $this->issueToViolation($issues);
    }

    public function issueToViolation(\Illuminate\Database\Eloquent\Collection $issues) {
        $count = 0;
        foreach ($issues as $issue) {
            if (Violation::where('issue_id', $issue['id'])->count() == 0) {
                $violation = new Violation;
                $violation->channel = $issue['object'] == "外包公司" ? "agency" : "field";
                $violation->contract_no = $issue['contract_no'];
                $violation->issue_id = $issue['id'];
                $violation->issue = $issue['issue'];
                $violation->status = 'waiting';
                $violation->region = $issue['region'];
                $violation->city_en = $issue['city'];
                $violation->name_collector = $issue['collector'];
                $violation->employee_id = $issue['employeeID'];
                $violation->month_violation = substr($issue['date'], 0, 7);
                $violation->date_violation = substr($issue['date'], -2);
                $violation->who_detected = $issue['qc_name'];
                $violation->who_decide_disciplinary = $issue['region_manager'];
                $violation->who_execute_disciplinary = $issue['region_manager'];
                $violation->month_belong = substr($issue['close_time'], 0, 4) . substr($issue['close_time'], 5, 2);
                $violation->close_time = $issue['close_time'];
                $violation->region_manager_email = $this->fetchManagerEmail($issue['collector']);
                $violation->save();
                $count++;
            }
        }
        return '{"created":"' . $count . '","total":"' . $issues->count() . '"}';
    }

    public function fetchManagerEmail($collector) {
        $manager = Collector::select('manager')->where('name_en', $collector)->first();
        if ($manager == false) {
            return '';
        }
        $email = Collector::select('email')->where('name_en', $manager->manager)->first();
        if ($email == false) {
            return '';
        }
        return $email->email;
    }

    public function issues() {
        return Arr::pluck(\App\IssueType::select('issue')->get(), "issue");
    }

    public function findIssuesByEid(Request $request) {
        $eid = $request->get('eid') ?: '2'; // if get no request, set "2" to get nothing.
        $start = $request->get('start');
        $end = $request->get('end');
        $issues = Issue::selectRaw("issue,count(*) as count")->where('employeeID', $eid)->where(function($query) use ($start, $end) {
                    if ($start && $end) {
                        $query->whereBetween("close_time", [$start, $end . " 23:59:59"]);
                    }
                })->where('result', '=', '有效')->whereIn('object', ['外催员/法律调查员', '外包公司'])->orderBy('count', 'desc')->groupBy("issue")->get();
        return $issues;
    }

}
