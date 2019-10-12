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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\ViolationFeedback;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    /**
     * 
     * @param type $id
     * @return view
     */
    public function show($id)
    {
        return view('violation.show')->withViolation(\App\Violation::findOrfail($id));
    }

    /**
     * search via contract No., name_collector, status, date range, region, ...
     * @return view|excel
     */
    public function search()
    {
        $key = \Request::get('s');
        if (trim($key) == '')
        {
            return back();
        }
        if (preg_match('/^\[.+\]/', $key) == null)
        {
            $column = preg_match('/^\d{3,}/', $key) ? 'contract_no' : 'name_collector';
            $data = Violation::where($column, 'like', '%' . trim($key) . '%');
        }
        else
        {
            $data = $this->smartSearch($key);
        }


        $excel = $data->count() > 6000 ? 0 : \Request::get('e');
        $title = ['id', 'channel', 'issue_id','issue', 'contract_no', 'cash_collect_amt', 'city_en', 'region', 'name_collector', 'employee_id', 'name_tl',
            'name_sv', 'month_violation', 'date_violation', 'month_propose_action', 'date_propose_action', 'month_decided_action',
            'date_decided action', 'month_executed_disciplinary', 'date_executed_disciplinary', 'month_verify_disciplinary',
            'date_verify_disciplinary', 'who_detected', 'who_proposed_disciplinary', 'who_decide_disciplinary', 'who_execute_disciplinary',
            'who_verify_disciplinary', 'punishment_proposed', 'punishment_decided', 'region_manager_comment', 'region_manager_approval',
            'region_approved_at', 'region_manager_email', 'country_manager_approval', 'country_approved_at', 'month_belong', 'close_time',
            'bonus_reduction', 'action_level', 'punishment_evidence', 'evidence_id', 'status', 'edit_log', 'punish_records', 'deleted_at',
            'updated_at', 'created_at'];
        return $excel ? $this->arrayToExcel($data->get()->toArray(), 'violations' . date("Ymd"), $title, 'A2') : view("violation.search")->withViolations($data->paginate(50)->appends(['s' => $key]));
    }

    public function smartSearch($key)
    {
        return Violation::where(function($query) use ($key) {
                        if (preg_match('/\[range\:(\d{4}\-\d{2}\-\d{2})\s(\d{4}\-\d{2}\-\d{2})\]/', $key, $matches))
                        {
                            $query->whereBetween('close_time', [$matches[1], $matches[2]]);
                        }
                        if (preg_match('/\[status\:(.+?)\]/', $key, $matches2))
                        {
                            $query->where('status', $matches2[1]);
                        }
                        if (preg_match('/\[issue\:(.+?)\]/', $key, $matches3))
                        {
                            $query->where('issue', $matches3[1]);
                        }
                        if (preg_match('/\[collector\:(.+?)\]/', $key, $matches4))
                        {
                            $query->where('name_collector', $matches4[1]);
                        }
                        if (preg_match('/\[channel\:(.+?)\]/', $key, $matches5))
                        {
                            $query->where('channel', $matches5[1]);
                        }
                        if (preg_match('/\[contract_no\:(.+?)\]/', $key, $matches4))
                        {
                            $query->where('contract_no', $matches4[1]);
                        }
                    });
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

    /**
     * import from spreadsheet
     * 
     * @return redirect
     */
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
        return redirect('violation');
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

    public function proposePunishment(Request $request)
    {
        try {
            //@todo: store proposed punishment
            $rules = [
                "punishment_evidence" => "required|min:5|max:2048",
                "bonus_reduction" => "required",
                "action_level" => "required|min:5|max:128",
                "ids" => "required"
            ];
            $this->validate($request, $rules);
            $idEmails = $request->get('ids');
            $ids = Arr::pluck($idEmails, 'id');
            Violation::whereIn("id", $ids)->update(array_merge($request->only(["punishment_evidence", "bonus_reduction", "action_level"]), [
                'who_proposed_disciplinary' => Auth::user()->name,
                'month_propose_action' => date('Y-m'),
                'date_propose_action' => date('d'),
                'status' => "proposed"
            ]));
            return '{"result":"success"}';
        } catch (\Illuminate\Validation\ValidationException $ex) {
            return ($ex->errors());
        } catch (Exception $ex) {
            return '{"result":"failed","msg":"' . $ex->getMessage() . '"}';
        }
    }

    public function setEmail(Request $request)
    {
        try {
            $idEmails = $request->get('ids');
            $ids = Arr::pluck($idEmails, 'id');
            $email = $request->get('email');
            $result = Violation::whereIn("id", $ids)
                    ->update(["region_manager_email" => "$email"]);
            if ($result === false)
            {
                return '{"result":"failed"}';
            }
            return '{"result":"success"}';
        } catch (Exception $ex) {
            return '{"result":"' . $ex->getMessage() . '"}';
        }
    }

    /**
     * 
     * @param type $email
     * @param type $violationId
     * @param type $toFillColumn
     * @return ViolationFeedback
     */
    public function createToken($email, $violationId, $toFillColumn = 'region_manager_comment')
    {
        if ($email == "" || $violationId == "")
        {
            return null;
        }
        $name = explode("@", $email)[0];
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));
        return ViolationFeedback::firstOrCreate(['violation_id' => $violationId], [
                    "name" => $name,
                    "token" => $token,
                    "to_fill_column" => $toFillColumn,
                    "email" => $email
        ]);
    }

    /**
     * 
     * @param ViolationFeedback $feedback
     * @return type Mail sending result
     */
    public function sendTokenLink(\App\ViolationFeedback $feedback)
    {
        $email = $feedback->email;
        $violation_id = $feedback->violation_id;
        $contactfirstname = $feedback->name;

        $createDate = new Carbon($feedback->created_at);
        $dueIn = $createDate->addDays(3);
        return Mail::send('violation.email', ['token' => $feedback->token, 'name' => $contactfirstname, 'dueIn' => $dueIn, 'id' => $violation_id], function ($message) use ($contactfirstname, $email, $violation_id) {
                    $message->from('FieldCollectionQM@homecredit.cn', 'Violation Confirm');
                    $message->bcc(Auth::user()->email)
                            ->to($email, $contactfirstname)->subject('催收违规处罚确认' . $violation_id);
                });
    }

    /**
     * 
     * @param String $email
     * @param String $id
     * @return email sending result
     */
    public function sendFeedbackLink($email, $id)
    {
        //create tokens and send emails        
        $feedback = $this->createToken($email, $id);
        if ($feedback)
        {
            return $this->sendTokenLink($feedback);
        }
    }

    /**
     * send multiple links to region managers to confirm
     * 
     * @param Request $request
     * @return string json
     */
    public function sendFeedbackLinks(Request $request)
    {
        try {
            $idEmails = $request->get('idEmails');
            foreach ($idEmails as $idEmail)
            {
                $validatior = Validator::make($idEmail, ['email' => 'required|email',
                            'id' => 'required']);
                if ($validatior->passes())
                {
                    $this->sendFeedbackLink($idEmail['email'], $idEmail['id']);
                }
            }
            return '{"result":"ok"}';
        } catch (\Exception $e) {
            return '{"result":"' . $e->getMessage() . '"}';
        }
    }

    /**
     * 
     * @param type $violation_id
     * @param type $token
     * @return type view
     */
    public function feedback($violation_id, $token)
    {
        $violation = Violation::findOrfail($violation_id);
        return view('violation.feedback')->withToken($token)->withViolation($violation);
    }

    /**
     * 
     * @param Request $request
     * @return type conditional redirect
     */
    public function feedbackStore(Request $request)
    {
        $request->flash();
        $rules = [
            'feedback' => 'required|min:5',
        ];
        $this->validate($request, $rules, [
            '*.required' => ':attribute必填',
            'min' => ':attribute不得少于:min个字符'
        ]);
        $violation_id = $request->get('violation_id');

        $tokenVerify = ViolationFeedback::where('violation_id', $violation_id)->first();

        if ($tokenVerify == false)
        {
            return back()->withInput()->withErrors('加密串码已失效或不存在，无法提交反馈。');
        }
        if ($request->get('token') != $tokenVerify->token)
        {
            return back()->withInput()->withErrors('加密串码已失效或不存在，无法提交反馈！');
        }

        $datetime1 = new DateTime($tokenVerify->created_at);
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);
        $diff = $interval->format('%a');
        if ($diff > 2)
        {
            $tokenVerify->delete();
            return back()->withInput()->withErrors('已超过反馈提交期限，如需提交或修改请申请新的链接。');
        }
        $violation = Violation::findOrFail($violation_id);
        if($violation->status != 'proposed' &&  $violation->status != 'rm approved'){
            return back()->withInput()->withErrors('后续流程已经执行，或者建议的处罚还没有设置。');
        }
        $violation->region_manager_comment = $request->get('feedback');
        $violation->region_manager_approval = $request->get('rm_approval');
        $violation->status = "rm approved";
        $violation->region_approved_at = date('Y-m-d H:i:s');

        if ($violation->save() == true)
        {
            return back()->withInput()->withErrors('提交成功！');
        }
        else
        {
            return back()->withInput()->withErrors('失败<br/>反馈提交失败！');
        }
    }

}
