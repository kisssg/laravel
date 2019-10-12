@extends('layouts.appnoauth') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Violations</div>
                <div class="card-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        {!! implode('<br>', $errors->all()) !!}
                    </div>
                    @endif
                    <form action='{{url('violation/feedback/'.$violation->id)}}' method="POST" onsubmit="if (!confirm('提交成功后，若要修改需再次申请链接！是否确认提交？')) {
                                event.preventDefault();
                            }
                            ;">
                        <table class='table table-bordered'>
                            <tr><td>ID:  {{$violation->id}}</td><td></td></tr>
                            <tr><td>LLI: {{$violation->name_collector}}</td><td>Employee ID 工号: {{$violation->employee_id}}</td></tr>
                            <tr><td>Date 日期: {{$violation->month_violation.' '.$violation->date_violation}}</td><td>Contract No.合同号: {{$violation->contract_no}}</td></tr>
                            {{csrf_field()}}
                            <input type='hidden' name='token' value="{{$token}}"/>
                            <input type='hidden' name='violation_id' value="{{$violation->id}}" />
                            <tr><td colspan="2">Issue 违规：{{$violation->Issue->issue_type.'->'.$violation->Issue->issue}}</td></tr>
                            <tr><td colspan="2">Remark 违规备注：{{$violation->Issue->remark}}</td></tr>
                            <tr><td colspan="2">Punish proposed 建议的处罚：{{$violation->punishment_proposed}}</td></tr>
                            <tr><td>Bonus reduction 奖金扣减：{{FLOOR(($violation->bonus_reduction)*100).'%'}}</td>
                                <td>Administration action 行政处罚：{{$violation->action_level}}</td></tr>
                                <tr>
                                    <td colspan="2">Punishment evidence 处罚依据：
                                        @if($violation->Evidence)
                                        {{$violation->Evidence->evidence}}
                                        @else
                                        {{$violation->punishment_evidence}}                                        
                                        @endif
                                    </td>
                            </tr>
                            @if(!$violation->punishment_decided =='')
                            <tr><td colspan="2">Punish decided 确定的处罚：{{$violation->punishment_decided}}</td></tr>
                            @endif
                        </table><label for="feedback">Feedback 您的反馈:</label><br/>
                        @if($violation->region_manager_comment)
                        <div>{{$violation->region_manager_approval.':'.$violation->region_manager_comment.' '.$violation->region_approved_at}}</div>
                        @endif
                        <select class='small' name='rm_approval'><option>同意Approve</option>
                            <option {{$violation->region_manager_approval=='不同意Not approve'?'selected':''}}>不同意Not approve</option></select>
                        <textarea name="feedback" value="" class='input-group'autofocus="true">{{old('feedback')?:$violation->region_manager_comment}}</textarea><br/>
                        <input class='btn btn-primary' type="submit" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection